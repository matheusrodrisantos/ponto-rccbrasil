<?php
namespace App\Service\RegrasRegistroPonto;

use App\Dto\FuncionarioDTO;

interface RegistroPontoInterface
{
    public function validar(FuncionarioDTO $funcionarioDTO): void;
}
