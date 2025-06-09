<?php

namespace App\Service\RegrasCalculaSaldo;

use App\Entity\Funcionario;

abstract class BaseRegrasCalculoSaldoInterface implements RegrasCalculoSaldoInterface
{

    protected $proximo;

    public function proximo(RegrasCalculoSaldoInterface $regrasCalculoSaldo): RegrasCalculoSaldoInterface
    {
        return $this->proximo = $regrasCalculoSaldo;
    }

    public function calcular(Funcionario $funcionario)
    {

        if ($this->proximo) {
            return $this->proximo->calcular(funcionario: $funcionario);
        }

        return null;
    }
}
