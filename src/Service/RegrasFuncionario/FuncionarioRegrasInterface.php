<?php

namespace App\Service\RegrasFuncionario;

use App\Dto\FuncionarioDTO;

interface FuncionarioRegrasInterface
{

    public function validar(FuncionarioDTO $funcionarioDTO): void;
}
