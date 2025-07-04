<?php


use PHPUnit\Framework\TestCase;
use App\Dto\DepartamentoDTO;
use App\Entity\Departamento;
use App\Factory\DepartamentoFactory;
use App\Tests\Helper\FakeDepartamentoTrait;
use App\Tests\Helper\FakeFuncionarioTrait;
use App\Repository\FuncionarioRepository;

class DepartamentoFactoryTest extends TestCase
{
    use FakeFuncionarioTrait;
    use FakeDepartamentoTrait;

    /** @var \App\Repository\FuncionarioRepository&\PHPUnit\Framework\MockObject\MockObject */
    public $repoMock;

    public function setUp(): void
    {

        $this->repoMock = $this->createMock(FuncionarioRepository::class);
    }

    public function test_create_entity_from_dto()
    {
        $departamentoDto = $this->criarDepartamentoDto();

        $this->repoMock->method('find')->willReturn($this->criarFuncionario());

        $factory = new DepartamentoFactory($this->repoMock);
        $departamento = $factory->createFromDto($departamentoDto);

        $this->assertInstanceOf(Departamento::class, $departamento);
    }

    public function test_create_dto_from_entity()
    {
        $departamento = $this->criarDepartamento();

        $factory = new DepartamentoFactory($this->repoMock);

        $departamentoDto = $factory->createDtoFromEntity($departamento);

        $this->assertInstanceOf(DepartamentoDTO::class, $departamentoDto);

        $this->assertEquals($departamento->getNome(), $departamentoDto->nome);
        $this->assertEquals($departamento->getDescricao(), $departamentoDto->descricao);
        $this->assertEquals($departamento->isAtivo(), $departamentoDto->ativo);

        $supervisor = $departamento->getSupervisor();
        if ($supervisor) {
            $this->assertEquals($supervisor->getId(), $departamentoDto->supervisorId);
        } else {
            $this->assertNull($departamentoDto->supervisorId);
        }
    }
}
