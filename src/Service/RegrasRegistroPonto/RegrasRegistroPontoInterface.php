<?php

namespace App\Service\RegrasRegistroPonto;

use App\Entity\Funcionario;
use App\Exception\RegraDeNegocioRegistroPontoException;;

interface RegrasRegistroPontoInterface
{
    /**
     * Validates and processes time clock registration
     *
     * @param Funcionario $funcionario Registration data
     * @return void
     * @throws RegraDeNegocioRegistroPontoException When validation fails
     */
    public function validar(Funcionario $funcionario): void;
}
