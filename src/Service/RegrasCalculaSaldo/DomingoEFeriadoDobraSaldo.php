<?php
namespace App\Service\RegrasCalculaSaldo;

use App\Entity\Funcionario;

class DomingoEFeriadoDobraSaldo extends BaseRegrasCalculoSaldoInterface
{
    public function calcular(Funcionario $funcionario)
    {
        /*
        // Verifica se o dia é domingo ou feriado
        if ($funcionario->isDomingo() || $funcionario->isFeriado()) {
            // Dobra o saldo do funcionário
            $funcionario->dobrarSaldo();
        }
        */
        // Chama o próximo manipulador na cadeia, se existir
        return parent::calcular($funcionario);
    }
    public function podeCalcular(): bool
    {
        // Implementar lógica para verificar se pode calcular
        return true; // Exemplo: sempre pode calcular
    }

}