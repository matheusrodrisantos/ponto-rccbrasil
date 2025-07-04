<?php
namespace App\Service\RegrasCalculaSaldo;

use App\Entity\SaldoHoras;
use App\Entity\ValueObject\DiaSemana;

class FeriadoDobraSaldoENaoDesconta extends BaseRegrasCalculoSaldo
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
        //TODO implementar lógica para verificar se a data é um feriado
        // Por enquanto, vamos assumir que a data é um feriado se for um domingo
        // Isso deve ser substituído por uma verificação real de feriados
        // Exemplo: verificar se a data está em uma lista de feriados
        $diaSemana = new DiaSemana($this->data);
        return $diaSemana->ehDomingo();
    }
}
