<?php

namespace App\Tests\Helper;

use App\Dto\FuncionarioDTO;
use Faker\Factory;

use App\Entity\Funcionario;
use App\Entity\ValueObject\Jornada;
use App\Entity\ValueObject\Cpf;
use App\Entity\ValueObject\Email;
use App\Entity\Enum\Regime;

trait FakeFuncionarioTrait
{

    protected function criarFuncionario(): Funcionario
    {
        $faker = Factory::create('pt_BR');

        $func = new Funcionario(
            new Jornada("09:00:00", "44:00:00"),
            new Cpf($faker->cpf(false)),
            new Email($faker->email())
        );

        $func->setAtivo($faker->boolean());
        $func->setNome($faker->name());
        $func->setRegime(Regime::HOME_OFFICE);
        $func->setVerificarLocalizacao($faker->boolean());

        return $func;
    }

    protected function criarFuncionarioDto():FuncionarioDTO{
        $faker = Factory::create('pt_BR');

        $funcDto = new FuncionarioDTO();

        $funcDto->cpf = $faker->cpf(false);
        $funcDto->roles = ["ROLE_USER", "ROLE_ADMIN"];
        $funcDto->email = $faker->email();
        $funcDto->nome = $faker->name();
        $funcDto->jornadaDiaria = "08:00:00";
        $funcDto->jornadaSemanal = "44:00:00";
        $funcDto->regime = Regime::PRESENCIAL;
        $funcDto->verificarLocalizacao = $faker->boolean();
        $funcDto->ativo = $faker->boolean();

        return $funcDto;
    }

    protected function gerarPayloadFuncionario(): array
    {
        $faker = Factory::create('pt_BR');

        return [
            "id" => $faker->randomNumber(2, true),
            "departamentoId"=> 1,
            "cpf" => $faker->cpf(false),
            "email" => $faker->unique()->safeEmail(),
            "nome" => $faker->name(),
            "jornadaDiaria" => "08:00:00",
            "jornadaSemanal" => "40:00:00",
            "regime" => $faker->randomElement(["PRESENCIAL", "HOME OFFICE", "HIBRIDO"]),
            "verificarLocalizacao" => $faker->boolean(),
            "ativo" => $faker->boolean(),
        ];
    }
}
