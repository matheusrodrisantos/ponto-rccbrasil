<?php

namespace App\Service\RegrasDepartamento;


use App\Dto\Departamento\DepartamentoInterfaceDTO;

interface RegrasDepartamentoInterface
{
    public function validar(DepartamentoInterfaceDTO $departamentoDTO): void;
}
