<?php

namespace App\Service\RegrasCalculaSaldo;

use App\Dto\FuncionarioDTO;
use DateTimeImmutable;

class RegrasFinalSemana implements RegistroPontoInterface
{
    public function validar(FuncionarioDTO $funcionarioDTO): void {}
}
