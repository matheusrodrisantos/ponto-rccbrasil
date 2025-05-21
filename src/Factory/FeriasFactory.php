<?php

namespace App\Factory;

use App\Entity\Ferias;
use App\Entity\Funcionario;
use App\Entity\ValueObject\DataFerias;
use App\Dto\FeriasDTO;

class FeriasFactory
{
    /**
     * Cria uma entidade Ferias a partir do DTO.
     */
    public function createEntityFromDto(
        FeriasDTO $dto,
        ?Funcionario $funcionario = null,
        ?Funcionario $userInclusao = null
    ): Ferias {
        $dataIni = new \DateTimeImmutable($dto->dataInicio);
        $dataFim = new \DateTimeImmutable($dto->dataFim);

        $dataFerias = new DataFerias($dataIni, $dataFim);
        $ferias = new Ferias($dataFerias);

        if ($funcionario) {
            $ferias->definirFuncionario($funcionario);
        }
        if ($userInclusao) {
            $ferias->definirResponsavelPelaInclusao($userInclusao);
        }

        return $ferias;
    }

    /**
     * Cria o DTO a partir da entidade Ferias.
     */
    public function createDtoFromEntity(Ferias $ferias): FeriasDTO
    {
        return new FeriasDTO(
            id: $ferias->getId(),
            funcionarioId: $ferias->funcionario()?->getId(),
            userInclusaoId: $ferias->responsavelPelaInclusao()?->getId(),
            dataInicio: $ferias->dataDeInicio(),
            dataFim: $ferias->dataDeFim(),
        );
    }
}
