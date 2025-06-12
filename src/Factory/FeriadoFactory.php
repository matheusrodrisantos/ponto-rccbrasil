<?php

namespace App\Factory;

use App\Dto\FeriadoDTO;
use App\Entity\Feriado;
use DateTimeImmutable;

final class FeriadoFactory
{
    public function createFromDTO(FeriadoDTO $dto): Feriado
    {
        $feriado = new Feriado();
        $feriado->setNome($dto->nome);
        // The DTO has $data as string, Feriado entity expects DateTimeImmutable
        // Also, the Feriado entity has inicio and fim, but the DTO only has data. For now, we'll set both to the same value.
        // We might need to adjust this later if the requirements change.
        if ($dto->data !== null) {
            $dataImmutable = new DateTimeImmutable($dto->data);
            $feriado->setInicio($dataImmutable);
            $feriado->setFim($dataImmutable);
        }
        $feriado->setNivel($dto->nivel);
        $feriado->setRecorrente($dto->recorrente);

        return $feriado;
    }
}
