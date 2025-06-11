<?php

namespace App\Service\RegrasCalculaSaldo;

use App\Entity\SaldoHoras;
use App\Entity\ValueObject\DiaSemana;

class DomingoDobraSaldoENaoDesconta extends BaseRegrasCalculoSaldo
{
    public function calcular(SaldoHoras $saldoHoras): ?SaldoHoras
    {
        if ($this->podeCalcular()) {

            $horas = $saldoHoras->getHorasTrabalhadasSegundos();

            $saldoHoras->recalcularSaldo(jornadaDiariaObrigatoria: -$horas);

            $saldoHoras->setObeservacao(obeservacao:'Saldo dobrado por ser domingo');

            return $saldoHoras;
        }
        return parent::calcular($saldoHoras);
    }
    private function podeCalcular(): bool
    {
        $diaSemana = new DiaSemana($this->data);
        return $diaSemana->ehDomingo();
    }
}
