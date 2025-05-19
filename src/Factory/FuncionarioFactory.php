<?php

namespace App\Factory;
use App\Dto\FuncionarioDTO;
use App\Entity\Enum\Regime;
use App\Entity\Funcionario;
use App\Entity\ValueObject\Cpf;
use App\Entity\ValueObject\Email;
use App\Entity\ValueObject\Jornada;

class FuncionarioFactory{

    public static function createFromDto(FuncionarioDTO $func):Funcionario
    {
        $cpf = new Cpf($func->cpf);
        $email = new Email($func->email);
        $jornada = new Jornada($func->jornadaDiaria, $func->jornadaSemanal);

        $funcionario = new Funcionario($jornada, $cpf, $email);

        $funcionario
            ->setNome($func->nome)
            ->setRegime(Regime::from($func->regime))
            ->setVerificarLocalizacao($func->verificarLocalizacao)
            ->setAtivo($func->ativo)
            ->setRoles($func->roles ?? []) 
            ->setPassword($func->password);  

        return $funcionario;
    }

}