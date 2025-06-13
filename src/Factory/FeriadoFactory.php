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
