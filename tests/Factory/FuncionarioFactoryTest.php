<?php

namespace Tests\Factory;
use PHPUnit\Framework\TestCase;
use App\Factory\FuncionarioFactory;
use App\Dto\FuncionarioDTO;
use App\Entity\Enum\Regime;
use App\Entity\Funcionario;
use App\Entity\ValueObject\Cpf;
use App\Entity\ValueObject\Email;
use App\Entity\ValueObject\Jornada;

class FuncionarioFactoryTest extends TestCase
{
    public function testCreateFuncionario()
    {

        $funcDto= new FuncionarioDTO();
        
        $funcDto->cpf='43523797861';
        $funcDto->roles=["ROLE_USER", "ROLE_ADMIN"];
        $funcDto->password="adasdasd";
        $funcDto->email="mamm@mamma.org.br";
        $funcDto->nome="João Silva";
        $funcDto->jornadaDiaria="08:00:00";
        $funcDto->jornadaSemanal="44:00:00";
        $funcDto->regime=Regime::PRESENCIAL;
        $funcDto->verificarLocalizacao=true;
        $funcDto->ativo=true;

        $funcionario = FuncionarioFactory::createFromDto($funcDto);
        $this->assertEquals('João Silva', $funcionario->getNome());
    }

    public function testCreateDtoFromEntity(){

        $func = new Funcionario(
            (new Jornada("09:00:00","44:00:00")),
            (new Cpf('43523797861')), 
            (new Email('rodriguescompositor@gmail.com'))
        );

        $func->setAtivo(1);
        $func->setPassword("fdasda");
        $func->setNome("JAO");
        $func->setRegime(Regime::HOME_OFFICE);
        $func->setVerificarLocalizacao(true);
        $func->setAtivo(true);

        $dto=FuncionarioFactory::createDtoFromEntity($func);
        $this->assertInstanceOf(FuncionarioDTO::class,$dto);

        $this->assertEquals(Regime::HOME_OFFICE->value,"HOME OFFICE");        
    }


}