<?php

namespace App\Service\RegrasCalculaSaldo;

use App\Entity\SaldoHoras;
use App\Entity\ValueObject\DiaSemana;
use DateTimeImmutable;

class FeriadoSabadoSextaMeioPeriodo extends BaseRegrasCalculoSaldo
{
    public function calcular(SaldoHoras $saldoHoras): ?SaldoHoras
    {
        if ($this->podeCalcular()) {
            $saldoHoras->adicionarHorasTrabalhadasSegundos(
                $saldoHoras->getHorasTrabalhadasSegundos()
            );

            $saldoHoras->recalcularSaldo(jornadaDiariaObrigatoria: 0);

            return $saldoHoras;
        }
        return parent::calcular($saldoHoras);
    }

    private function podeCalcular(): bool
    {
        //TODO implementar dominios feriados
        $diaSemana = new DiaSemana(new DateTimeImmutable());
        if ($diaSemana->ehSexta()) {
            return true;
        }
        return false;
    }
}
