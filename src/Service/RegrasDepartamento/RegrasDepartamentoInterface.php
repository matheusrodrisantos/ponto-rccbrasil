<?php

namespace App\Service\RegrasDepartamento;

use App\Dto\DepartamentoDTO;
use App\Dto\DepartamentoInputDTO;

interface RegrasDepartamentoInterface
{
    public function validar(DepartamentoInputDTO $departamentoDTO): void;
}
