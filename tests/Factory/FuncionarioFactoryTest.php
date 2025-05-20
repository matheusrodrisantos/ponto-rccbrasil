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
use App\Tests\Helper\FakeFuncionarioTrait;
use Faker\Factory;

class FuncionarioFactoryTest extends TestCase
{
    use FakeFuncionarioTrait;

    private $faker;

    public function setUp():void{
        $this->faker = Factory::create('pt_BR');   
    }

    public function testCreateFuncionario()
    {
    
        $funcDto = $this->criarFuncionarioDto();

        $funcionario = FuncionarioFactory::createFromDto($funcDto);
        $this->assertNotEmpty($funcDto->nome);
    }

    public function testCreateDtoFromEntity(){

        $func = $this->criarFuncionario();

        $dto=FuncionarioFactory::createDtoFromEntity($func);
        $this->assertInstanceOf(FuncionarioDTO::class,$dto);

    }


}