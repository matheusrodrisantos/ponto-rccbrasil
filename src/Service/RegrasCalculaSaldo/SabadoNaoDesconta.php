<?php

namespace App\Service\RegrasCalculaSaldo;

use App\Entity\SaldoHoras;
use App\Entity\ValueObject\DiaSemana;

class SabadoNaoDesconta extends BaseRegrasCalculoSaldo
{
    public function calcular(SaldoHoras $saldoHoras): ?SaldoHoras
    {
        if ($this->podeCalcular()) {

            $saldoHoras->setObeservacao(obeservacao: 'Saldo não descontado por ser sábado');

            return $saldoHoras->recalcularSaldo(jornadaDiariaObrigatoria: 0);
        }

        return parent::calcular($saldoHoras);
    }
    private function podeCalcular(): bool
    {
        $diaSemana = new DiaSemana($this->data);
        return $diaSemana->ehSabado();
    }
}
