<?php

namespace App\Sevice\RegrasFuncionario;

use App\Dto\FuncionarioDTO;

interface FuncionarioRegrasInterface
{

    public function validar(FuncionarioDTO $funcionarioDTO): void;
}
