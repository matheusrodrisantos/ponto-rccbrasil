<?php

namespace App\Factory;

use App\Dto\DepartamentoInputDTO; // Changed
use App\Dto\DepartamentoOutputDTO; // Added
use App\Entity\Departamento;
use App\Repository\FuncionarioRepository;

class DepartamentoFactory
{
    public function __construct(private FuncionarioRepository $funcionarioRepository) {}

    // Changed method name and parameter type
    public function createEntityFromInputDTO(DepartamentoInputDTO $dpto): Departamento
    {
        $departamento = new Departamento();
        $departamento->setNome($dpto->nome);
        $departamento->setDescricao($dpto->descricao);
        // Assuming 'ativo' is managed by default in InputDTO or here if needed
        $departamento->setAtivo($dpto->ativo ?? true); // Ensure 'ativo' is handled

        if ($dpto->supervisorId !== null) {
            $supervisor = $this->funcionarioRepository->find($dpto->supervisorId);
            $departamento->setSupervisor($supervisor);
        }

        return $departamento;
    }

    // Changed method name and return type
    public function createOutputDTOFromEntity(Departamento $departamento): DepartamentoOutputDTO
    {
        $dto = new DepartamentoOutputDTO(); // Changed to OutputDTO
        $dto->id = $departamento->getId();
        $dto->nome = $departamento->getNome();
        $dto->descricao = $departamento->getDescricao();
        $dto->ativo = $departamento->isAtivo();

        $supervisor = $departamento->getSupervisor();
        $dto->supervisorId = $supervisor ? $supervisor->getId() : null;

        return $dto;
    }
}
