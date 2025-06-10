<?php
namespace App\Service\RegrasCalculaSaldo;

use App\Entity\SaldoHoras;

interface RegrasCalculoSaldoInterface
{
    public function proximo(RegrasCalculoSaldoInterface $handler):RegrasCalculoSaldoInterface;

    public function calcular(SaldoHoras $saldoHoras): ?SaldoHoras;
}
