<?php

namespace Tests\Factory;
use PHPUnit\Framework\TestCase;
use App\Factory\FuncionarioFactory;
use App\Dto\FuncionarioDTO;
use App\Entity\Enum\Regime;
use App\Entity\Funcionario;

class FuncionarioFactoryTest extends TestCase
{
    public function testCreateFuncionario()
    {

        $funcDto= new FuncionarioDTO();
        
        $funcDto->setCpf(1);
        $funcDto->setRoles(["ROLE_USER", "ROLE_ADMIN"]);
        $funcDto->setPassword("adasdasd");
        $funcDto->setEmail("mamm@mamma");
        $funcDto->setNome("mam");
        $funcDto->setJornadaDiaria("mam");
        $funcDto->setJornadaSemanal("mam");
        $funcDto->setRegime(Regime::PRESENCIAL);
        $funcDto->setVerificarLocalizacao(true);
        $funcDto->setAtivo(true);

        $funcionario = FuncionarioFactory::createFromDto($funcDto);

        $this->assertEquals('João Silva', $funcionario->getNome());
        
        $this->assertEquals('Desenvolvedor', $funcionario->getCargo());
    }


}