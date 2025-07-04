<?php

namespace App\Factory;

use App\Dto\Departamento\DepartamentoInputDTO;
use App\Dto\Departamento\DepartamentoOutputDTO; 
use App\Entity\Departamento;
use App\Repository\FuncionarioRepository;

class DepartamentoFactory
{
    public function __construct(private FuncionarioRepository $funcionarioRepository) {}

    
    public function createEntityFromInputDTO(DepartamentoInputDTO $dpto): Departamento
    {
        $departamento = new Departamento();
        $departamento->setNome($dpto->nome);
        $departamento->setDescricao($dpto->descricao);
        $departamento->setAtivo($dpto->ativo ?? true); 

        if ($dpto->supervisorId !== null) {
            $supervisor = $this->funcionarioRepository->find($dpto->supervisorId);
            $departamento->setSupervisor($supervisor);
        }

        return $departamento;
    }

    public function createOutputDTOFromEntity(Departamento $departamento): DepartamentoOutputDTO
    {
        $dto = new DepartamentoOutputDTO(); 
        $dto->id = $departamento->getId();
        $dto->nome = $departamento->getNome();
        $dto->descricao = $departamento->getDescricao();
        $dto->ativo = $departamento->isAtivo();

        $supervisor = $departamento->getSupervisor();
        $dto->supervisorId = $supervisor ? $supervisor->getId() : null;

        return $dto;
    }
}
