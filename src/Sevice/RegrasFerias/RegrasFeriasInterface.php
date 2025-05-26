<?php

namespace App\Sevice\RegrasFerias;
use App\Dto\FeriasDTO;

interface RegrasFeriasInterface{

    public function validar(FeriasDTO $ferias);

}