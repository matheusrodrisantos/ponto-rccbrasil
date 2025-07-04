<?php 
namespace App\Service\RegrasRegistroPonto;

use App\Entity\Funcionario;
use Exception;


class RegraFuncionarioBloqueadoNaoRegistraPonto
{
    public function validar(Funcionario $funcionario): void
    {
        if (!$funcionario->isAtivo()) {
            throw new Exception('Funcionário está bloqueado e não pode registrar ponto');
        }
    }
}