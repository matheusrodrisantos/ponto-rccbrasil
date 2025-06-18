<?php

namespace App\Factory;

use App\Dto\Feriado\FeriadoInputDTO;
use App\Dto\Feriado\FeriadoOutputDTO;
use App\Entity\Enum\FeriadoNivel;
use App\Entity\ValueObject\DataFeriado;
use App\Entity\Feriado;
use DateTimeImmutable;

final class FeriadoFactory
{

    public function createEntityFromInputDTO(FeriadoInputDTO $dto): Feriado
    {
        if ($dto->data !== null) {
            $dataImmutable = new DateTimeImmutable($dto->data);
        }

        $dataFeriado = new DataFeriado($dataImmutable);

        $feriado = new Feriado($dataFeriado);
        $feriado->setNome($dto->nome);

        $feriado->setNivel($dto->nivel);

        return $feriado;
    }


    public function createOutputDTOFromEntity(Feriado $feriado): FeriadoOutputDTO
    {
        return new FeriadoOutputDTO(
            nome: $feriado->getNome(),
            data: $feriado->getData(),
            nivel: $feriado->getNivel()

        );
    }
}
