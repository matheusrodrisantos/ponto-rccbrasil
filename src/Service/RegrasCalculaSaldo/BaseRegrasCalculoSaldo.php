<?php

namespace App\Service\RegrasCalculaSaldo;

use App\Entity\SaldoHoras;
use DateTimeImmutable;

abstract class BaseRegrasCalculoSaldo implements RegrasCalculoSaldoInterface
{
    protected $proximo;

    protected ?DateTimeImmutable $data;

    public function __construct(?DateTimeImmutable $data = null)
    {
        $this->data = $data ?? new DateTimeImmutable();
    }

    public function proximo(RegrasCalculoSaldoInterface $regrasCalculoSaldo): RegrasCalculoSaldoInterface
    {
        return $this->proximo = $regrasCalculoSaldo;
    }

    public function calcular(SaldoHoras $saldoHoras): ?SaldoHoras
    {
        if ($this->proximo) {
            return $this->proximo->calcular(saldoHoras: $saldoHoras);
        }

        return null;
    }
}
