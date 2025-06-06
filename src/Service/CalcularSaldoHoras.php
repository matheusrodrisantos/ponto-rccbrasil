<?php

namespace App\Service;

use App\Entity\Funcionario;
use App\Entity\SaldoHoras;

class CalcularSaldoHoras
{
    public function __construct(
        private Funcionario $funcionario,
        private SaldoHoras $saldoHoras
    ) {}

    public function calculaSaldoHoras(): SaldoHoras
    {
        $jornadaDiariaSegundos = $this->funcionario->jornadaDiariaSegundos();
        $this->saldoHoras->recalcularSaldo($jornadaDiariaSegundos);
        return $this->saldoHoras;
    }
}
