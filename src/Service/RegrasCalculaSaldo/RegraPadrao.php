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
        return $saldoHoras;
    }
    
}
