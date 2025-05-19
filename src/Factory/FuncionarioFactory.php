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
            ->setRegime($func->regime)
            ->setVerificarLocalizacao($func->verificarLocalizacao)
            ->setAtivo($func->ativo)
            ->setRoles($func->roles ?? []) 
            ->setPassword($func->password);  

        return $funcionario;
    }



    public static function createDtoFromEntity(Funcionario $funcionario): FuncionarioDTO
    {
        $dto = new FuncionarioDTO();
        $dto->cpf = (string) $funcionario->getCpf();
        $dto->email = (string) $funcionario->getEmail();
        $dto->jornadaDiaria = $funcionario->getJornadaDiaria();
        $dto->jornadaSemanal = $funcionario->getJornadaSemanal();
        $dto->nome = $funcionario->getNome();
        $dto->regime = $funcionario->getRegime();
        $dto->verificarLocalizacao = $funcionario->isVerificarLocalizacao();
        $dto->ativo = $funcionario->isAtivo();
        $dto->roles = $funcionario->getRoles();
        $dto->password = $funcionario->getPassword();

        return $dto;
    }
}