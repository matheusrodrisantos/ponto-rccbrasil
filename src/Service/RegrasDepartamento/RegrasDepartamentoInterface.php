<?php

namespace App\Service\RegrasDepartamento;

use App\Dto\DepartamentoDTO;

interface RegrasDepartamentoInterface
{
    public function validar(DepartamentoDTO $departamentoDTO): void;
}
