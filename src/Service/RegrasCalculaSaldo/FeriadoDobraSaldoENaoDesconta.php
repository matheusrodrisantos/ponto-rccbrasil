<?php
namespace App\Service\RegrasCalculaSaldo;

use App\Entity\Funcionario;
use App\Entity\ValueObject\DiaSemana;
use DateTimeImmutable;

class FeriadoDobraSaldoENaoDesconta extends BaseRegrasCalculoSaldo
{
    public function calcular(Funcionario $funcionario)
    {

        if($this->podeCalcular()){
            //TODO calcula saldo para o domingo
        }
        // Chama o próximo manipulador na cadeia, se existir
        return parent::calcular($funcionario);
    }
    public function podeCalcular(): bool
    {
       

        return false; 
    }

}
