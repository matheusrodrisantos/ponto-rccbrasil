<?php

namespace App\Factory;

use App\Entity\Ferias;
use App\Entity\Funcionario;
use App\Entity\ValueObject\DataFerias;
use App\Dto\FeriasDto;

class FeriasFactory
{
    /**
     * @param FeriasDto $dto
     * @param Funcionario|null $funcionario
     * @param Funcionario|null $userInclusao
     * @return Ferias
     */
    public function createEntityFromDto(
        FeriasDto $dto,
        ?Funcionario $funcionario = null,
        ?Funcionario $userInclusao = null
    ): Ferias {
        $dataFerias = new DataFerias($dto->dataIni, $dto->dataFim);
        $ferias = new Ferias($dataFerias);

        if ($funcionario) {
            $ferias->setFuncionario($funcionario);
        }
        if ($userInclusao) {
            $ferias->setUserInclusao($userInclusao);
        }
        if ($dto->createdAt) {
            $ferias->setCreatedAt($dto->createdAt);
        }
        if ($dto->updatedAt) {
            $ferias->setUpdatedAt($dto->updatedAt);
        }

        return $ferias;
    }

    /**
     * @param Ferias $entity
     * @return FeriasDto
     */
    public function createDtoFromEntity(Ferias $entity): FeriasDto
    {
        $dto = new FeriasDto();
        $dto->id = $entity->getId();
        $dto->funcionarioId = $entity->getFuncionario()?->getId();
        $dto->userInclusaoId = $entity->getUserInclusao()?->getId();
        $dto->dataIni = $entity->getDataIni();
        $dto->dataFim = $entity->getDataFim();
        $dto->createdAt = $entity->getCreatedAt();
        $dto->updatedAt = $entity->getUpdatedAt();

        return $dto;
    }
}