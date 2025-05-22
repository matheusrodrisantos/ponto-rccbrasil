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

    public function detalhe(int $id) {

        $this->func = $this->funcionarioRepository->find($id);

        $feriasFuncionario=$this->func->getFerias();
        $registroPontoFuncionario=$this->func->getRegistroPontos();
        $saldoHorasFuncionario=$this->func->getSaldoHoras();


        $feriasDTOs = [];

        foreach ($feriasFuncionario as $ferias) {
            $feriasDTOs[] = [
                'id' => $ferias->getId(),
                'dataInicio' => $ferias->dataDeInicio(),
                'dataFim' => $ferias->dataDeFim(),
                'funcionarioId'=>$ferias->funcionario(),
                'userInclusaoId'=>$ferias->responsavelPelaInclusao()
            ];
        }


        $dto = new FuncionarioDTO(
            id:$this->func->getId(),
            cpf:$this->func->getCpf(),
            departamentoId:$this->func->getDepartamentoId()

        );

    }
}