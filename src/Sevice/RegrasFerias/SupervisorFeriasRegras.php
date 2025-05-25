<?php

namespace App\Sevice\RegrasFerias;

use App\Dto\FeriasDTO;
use App\Repository\FuncionarioRepository;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SupervisorFeriasRegras extends CadeiaRegrasBase{

    public function __construct(private FuncionarioRepository $funcionarioRepository){}

    public function validar(FeriasDTO $ferias):void 
    {   
         if($ferias->userInclusaoId===null){
            throw new InvalidArgumentException('Precisa de um supervisor que adicione');
        }

        $this->buscarSupervisor($ferias);

    }

    private function buscarSupervisor(FeriasDTO $ferias) :void {
 
        $responsavel=$this->funcionarioRepository->find($ferias->userInclusaoId);

        if (!$responsavel) {
            throw new NotFoundHttpException("Supervisor com ID {$ferias->userInclusaoId} não encontrado ou inativo.");
        }
    }

    




}