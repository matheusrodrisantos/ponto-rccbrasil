<?php

namespace App\Service\RegrasCalculaSaldo;

use App\Entity\SaldoHoras;

class RegraPadrao extends BaseRegrasCalculoSaldo
{
    public function calcular(SaldoHoras $saldoHoras): ?SaldoHoras
    {
        $saldoHoras->recalcularSaldo(jornadaDiariaObrigatoria: 
            $saldoHoras->jornadaDiariaSegundosFuncionario()
        );

        $saldoHoras->setObeservacao(
            obeservacao:"Saldo recalculado com base na jornada diária obrigatória do funcionário."
        );
        return $saldoHoras;
    }
    
}
