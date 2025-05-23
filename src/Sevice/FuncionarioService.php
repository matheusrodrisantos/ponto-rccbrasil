<?php

namespace App\Sevice;

use App\Dto\FeriasDTO;
use App\Dto\FuncionarioDTO;
use App\Entity\Funcionario;
use App\Factory\FuncionarioFactory;
use App\Repository\FuncionarioRepository;

class FuncionarioService{

    private Funcionario $func;
    
    public function __construct(
        private FuncionarioRepository $funcionarioRepository,
        private FuncionarioFactory $funcionarioFactory
    ){}

    public function createEntity(FuncionarioDTO $funcDto):FuncionarioDTO{

        $this->func = $this->funcionarioFactory->createFromDto($funcDto);

        $this->funcionarioRepository->create($this->func);

        return $this->funcionarioFactory->createDtoFromEntity($this->func);

    }

    public function listarFeriasFuncionario(int $id){

        $this->func = $this->funcionarioRepository->find($id);
    }

    public function detalhe(int $id):?FuncionarioDTO {

        
        $this->func = $this->funcionarioRepository->find($id);
        
        $feriasFuncionario=$this->func->getFerias();
        //print_r($this->func);
       /* 
        $registroPontoFuncionario=$this->func->getRegistroPontos();
        $saldoHorasFuncionario=$this->func->getSaldoHoras();
        $saldoHorasFuncionario=$this->func->getSaldoHoras();
*/

       //$feriasFuncionario=$this->func->getFerias();
        echo json_encode($feriasFuncionario);
        $ferias = [];

        foreach ($feriasFuncionario as $feria) {
            $ferias[] = [
                'id' => $feria->getId(),
                'dataInicio' => $feria->dataDeInicio(),
                'dataFim' => $feria->dataDeFim(),
                'funcionarioId'=>$feria->funcionario(),
                'userInclusaoId'=>$feria->responsavelPelaInclusao()
            ];
        }

        return new FuncionarioDTO(
            id:$this->func->getId(),
            cpf:$this->func->getCpf(),
            //departamento:$this->func->getDepartamento(),
            roles: $this->func->getRoles(),
            email: $this->func->getEmail(),
            nome:$this->func->getNome(),
            jornadaDiaria:$this->func->getJornadaDiaria(), 
            jornadaSemanal:$this->func->getJornadaSemanal(),
            regime:$this->func->getRegime(),
            verificarLocalizacao:$this->func->isVerificarLocalizacao(),
            ativo:$this->func->isAtivo(),
            ferias:$ferias
        );

    }
}