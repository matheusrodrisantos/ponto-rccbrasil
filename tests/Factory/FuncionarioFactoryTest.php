<?php

namespace Tests\Factory;

use PHPUnit\Framework\TestCase;
use App\Factory\FuncionarioFactory;
use App\Dto\FuncionarioDTO;
use App\Entity\Funcionario;
use App\Repository\DepartamentoRepository;
use App\Tests\Helper\FakeDepartamentoTrait;
use App\Tests\Helper\FakeFuncionarioTrait;


class FuncionarioFactoryTest extends TestCase
{
    use FakeFuncionarioTrait;
    use FakeDepartamentoTrait;

    /** @var \App\Repository\DepartamentoRepository&\PHPUnit\Framework\MockObject\MockObject */
    public $repoMock;

    private $faker;

    public function setUp(): void
    {
        $this->repoMock = $this->createMock(DepartamentoRepository::class);
    }

    public function testCreateFuncionario()
    {

        $funcDto = $this->criarFuncionarioDto();

        $this->repoMock->method('find')->willReturn($this->criarDepartamento());

        $funcionarioFactory = new FuncionarioFactory($this->repoMock);
        $funcionario = $funcionarioFactory->createFromDto($funcDto);

        $this->assertInstanceOf(Funcionario::class, $funcionario);

        $this->assertNotEmpty($funcDto->nome);
    }

    public function testCreateDtoFromEntity()
    {

        $func = $this->criarFuncionario();
        $func->setDepartamento($this->criarDepartamento());

        $funcionarioFactory = new FuncionarioFactory($this->repoMock);

        $dto = $funcionarioFactory->createDtoFromEntity($func);
        $this->assertInstanceOf(FuncionarioDTO::class, $dto);
    }
}
