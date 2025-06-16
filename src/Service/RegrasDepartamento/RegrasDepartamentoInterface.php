<?php

namespace App\Service\RegrasDepartamento;


use App\Dto\DepartamentoInterfaceDTO;

interface RegrasDepartamentoInterface
{
    public function validar(DepartamentoInterfaceDTO $departamentoDTO): void;
}
