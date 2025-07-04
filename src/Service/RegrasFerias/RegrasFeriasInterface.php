<?php

namespace App\Service\RegrasFerias;

use App\Dto\FeriasDTO;

interface RegrasFeriasInterface
{
    public function validar(FeriasDTO $ferias);
}
