<?php

namespace App\Factory;

use App\Dto\Feriado\FeriadoInputDTO;  
use App\Dto\Feriado\FeriadoOutputDTO; 
use App\Entity\Enum\FeriadoNivel; 
use App\Entity\Feriado;
use DateTimeImmutable;

final class FeriadoFactory
{
    
    public function createEntityFromInputDTO(FeriadoInputDTO $dto): Feriado
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

    
    public function createOutputDTOFromEntity(Feriado $feriado): FeriadoOutputDTO
    {
        return new FeriadoOutputDTO(
            nome: $feriado->getNome(),
            data: $feriado->getInicio()?->format('Y-m-d'),
            nivel: $feriado->getNivel(),
            recorrente: $feriado->isRecorrente()
        );
    }
}
