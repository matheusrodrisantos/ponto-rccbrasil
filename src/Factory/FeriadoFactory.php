<?php

namespace App\Factory;

use App\Dto\FeriadoInputDTO;  // Changed
use App\Dto\FeriadoOutputDTO; // Added
use App\Entity\Enum\FeriadoNivel; // Ensure this is imported if FeriadoOutputDTO constructor needs it directly
use App\Entity\Feriado;
use DateTimeImmutable;

final class FeriadoFactory
{
    // Renamed method and updated parameter type
    public function createEntityFromInputDTO(FeriadoInputDTO $dto): Feriado
    {
        $feriado = new Feriado();
        $feriado->setNome($dto->nome);
        
        if ($dto->data !== null) {
            $dataImmutable = new DateTimeImmutable($dto->data);
            $feriado->setInicio($dataImmutable);
            $feriado->setFim($dataImmutable); // Assuming Fim is same as Inicio for Feriado
        }
        $feriado->setNivel($dto->nivel); // Assumes $dto->nivel is already a FeriadoNivel enum instance
        $feriado->setRecorrente($dto->recorrente);

        return $feriado;
    }

    // Added new method
    public function createOutputDTOFromEntity(Feriado $feriado): FeriadoOutputDTO
    {
        return new FeriadoOutputDTO(
            nome: $feriado->getNome(),
            data: $feriado->getInicio() ? $feriado->getInicio()->format('Y-m-d') : null,
            nivel: $feriado->getNivel(),
            recorrente: $feriado->isRecorrente()
        );
    }
}
