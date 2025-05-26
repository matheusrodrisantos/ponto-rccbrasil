<?php

namespace App\Sevice\RegrasFerias;

use App\Dto\FeriasDTO;
use App\Repository\FeriasRepository;
use DateTime;
use InvalidArgumentException;

class PeriodoFeriasRegras implements RegrasFeriasInterface {

    public function __construct(private FeriasRepository $feriasRepository) {
    }

    public function validar(FeriasDTO $feriasDto):void
    {
        if($feriasDto->dataInicio===null){            
            throw new InvalidArgumentException(message:'Precisa de uma data Inicial');
        }
        
        if($feriasDto->dataFim===null){            
            throw new InvalidArgumentException(message:'Precisa de uma data Final');
        }

        $ferias=$this->feriasRepository->buscarPorPeriodo(
            new DateTime($feriasDto->dataInicio),
            new DateTime($feriasDto->dataFim),
            $feriasDto->funcionarioId
        );
        
        if ($ferias) {
            throw new InvalidArgumentException(message:"Já tem uma data cadastrada para esse periodo");
        }

    }
}