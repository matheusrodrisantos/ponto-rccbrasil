<?php 
namespace App\Service\RegrasRegistroPonto;

use App\Entity\Funcionario;

class CadeiaRegrasRegistroPonto
{
    private array $regras;

    public function __construct(array $regras)
    {
        $this->regras = $regras;
    }

    public function validar(Funcionario $funcionario): void
    {
        foreach ($this->regras as $regra) {
            $regra->validar($funcionario);
        }
    }
}