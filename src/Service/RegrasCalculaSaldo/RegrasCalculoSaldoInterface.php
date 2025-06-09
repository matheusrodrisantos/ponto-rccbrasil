<?php
namespace App\Service\RegrasCalculaSaldo;

use App\Dto\FuncionarioDTO;
use App\Entity\Funcionario;

interface RegrasCalculoSaldoInterface
{
    //public function podeCalcular():bool;

    public function proximo(RegrasCalculoSaldoInterface $handler):RegrasCalculoSaldoInterface;

    public function calcular(Funcionario $funcionario);
}
