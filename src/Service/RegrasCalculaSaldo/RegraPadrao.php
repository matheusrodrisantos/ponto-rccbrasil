<?php

namespace App\Service\RegrasCalculaSaldo;

use App\Entity\SaldoHoras;
use App\Entity\ValueObject\DiaSemana;

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
