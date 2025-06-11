<?php  
namespace App\Service\RegrasRegistroPonto;

use App\Entity\Funcionario;
use Exception;


class RegraFuncionarioEmFeriasNaoRegistraPonto implements RegrasRegistroPontoInterface
{
    public function validar(Funcionario $funcionario): void
    {
        if ($funcionario->estaDeFerias()) {
            throw new Exception('Funcionário está de férias e não pode registrar ponto');
        }
    }
}