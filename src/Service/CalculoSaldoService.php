<?php 
namespace App\Service;

use App\Entity\SaldoHoras;
use App\Service\RegrasCalculaSaldo\DomingoDobraSaldoENaoDesconta;
use App\Service\RegrasCalculaSaldo\RegraPadrao;
use App\Service\RegrasCalculaSaldo\SabadoNaoDesconta;

class CalculoSaldoService
{
    public function __construct(
        private DomingoDobraSaldoENaoDesconta $regraDomingo,
        private SabadoNaoDesconta $regraSabado,
        private RegraPadrao $regraPadrao
    ) {}
    public function calcular(SaldoHoras $saldoHoras): SaldoHoras
    {
       
        $this->regraDomingo->proximo($this->regraSabado);
        $this->regraSabado->proximo($this->regraPadrao);
        
        return $this->regraDomingo->calcular($saldoHoras);
    }

    public function verificarRegrasSaldos(SaldoHoras $saldoHoras): SaldoHoras
    {
        $this->regraDomingo->proximo($this->regraSabado);
        $this->regraSabado->proximo($this->regraPadrao);
        
        return $this->regraDomingo->calcular($saldoHoras);
    }
}