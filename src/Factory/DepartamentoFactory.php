<?php

namespace App\Factory;

use App\Dto\DepartamentoDTO;
use App\Entity\Departamento;

class DepartamentoFactory{

    public static function createFromDto(DepartamentoDTO $dpto):Departamento{
        
        $departamento = new Departamento();
        $departamento->setNome($dpto->nome);
        $departamento->setDescricao($dpto->descricao);
        $departamento->setAtivo($dpto->ativo);
        $departamento->setSupervisor($dpto->supervisor);

        return $departamento;
    }

    public static function createDtoFromEntity(Departamento $departamento): DepartamentoDTO{
        
        $dto = new DepartamentoDTO();
        $dto->nome=$departamento->getNome();
        $dto->descricao = $departamento->getDescricao();
        $dto->ativo = $departamento->isAtivo();
        $dto->supervisor = $departamento->getSupervisor();

        return $dto;
    }
}