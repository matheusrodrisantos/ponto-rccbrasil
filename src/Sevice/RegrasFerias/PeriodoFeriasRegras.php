<?php

namespace App\Sevice\RegrasFerias;

use App\Dto\FeriasDTO;
use App\Repository\FeriasRepository;

class PeriodoFeriasRegras extends CadeiaRegrasBase{

    public function __construct(private FeriasRepository $feriasRepository) {
    }

    public function validar(FeriasDTO $ferias)
    {
        
    }


}