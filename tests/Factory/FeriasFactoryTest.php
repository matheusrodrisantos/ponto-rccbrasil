<?php

namespace App\Tests\Factory;

use PHPUnit\Framework\TestCase;
use App\Factory\FeriasFactory;
use App\Repository\FeriasRepository;
use App\Repository\FuncionarioRepository;
use App\Dto\FeriasDTO;
use App\Entity\Ferias;
use App\Entity\Funcionario;
use App\Entity\ValueObject\DataFerias;

class FeriasFactoryTest extends TestCase
{
    private FeriasRepository $feriasRepository;
    private FuncionarioRepository $funcionarioRepository;
    private FeriasFactory $factory;

    protected function setUp(): void
    {
        $this->feriasRepository = $this->createMock(FeriasRepository::class);
        $this->funcionarioRepository = $this->createMock(FuncionarioRepository::class);

        $this->factory = new FeriasFactory(
            $this->feriasRepository,
            $this->funcionarioRepository
        );
    }

    public function testCreateEntityFromDto(): void
    {
        $dto = new FeriasDTO(
            id: null,
            funcionarioId: 1,
            userInclusaoId: 2,
            dataInicio: '2025-01-01',
            dataFim: '2025-01-15'
        );

        $funcionario = $this->createMock(Funcionario::class);
        $responsavel = $this->createMock(Funcionario::class);

        $this->feriasRepository
            ->method('find')
            ->willReturnCallback(function ($id) use ($funcionario, $responsavel) {
                return match ($id) {
                    1 => $funcionario,
                    2 => $responsavel,
                    default => null,
                };
            });

        $ferias = $this->factory->createEntityFromDto($dto);

        $this->assertInstanceOf(Ferias::class, $ferias);
        $this->assertEquals(
            '2025-01-01',
            $ferias->dataDeInicio(),
            'Data de início incorreta'
        );
        $this->assertEquals(
            '2025-01-15',
            $ferias->dataDeFim(),
            'Data de fim incorreta'
        );
        $this->assertNotNull($ferias->funcionario(), 'Funcionario não foi definido');
        $this->assertSame($funcionario, $ferias->funcionario(), 'Funcionario não corresponde');
        $this->assertNotNull($ferias->responsavelPelaInclusao(), 'Responsável não foi definido');
        $this->assertSame($responsavel, $ferias->responsavelPelaInclusao(), 'Responsável não corresponde');
    }

    public function testCreateDtoFromEntity(): void
    {
        $funcionario = $this->createMock(Funcionario::class);
        $responsavel = $this->createMock(Funcionario::class);

        $funcionario->method('getId')->willReturn(1);
        $responsavel->method('getId')->willReturn(2);

        $dataFerias = new DataFerias(
            new \DateTimeImmutable('2025-01-01'),
            new \DateTimeImmutable('2025-01-15')
        );

        $ferias = new Ferias($dataFerias);

        // Setando ID via reflexão
        $refId = new \ReflectionProperty(Ferias::class, 'id');
        $refId->setAccessible(true);
        $refId->setValue($ferias, 99);

        $ferias->definirFuncionario($funcionario);
        $ferias->definirResponsavelPelaInclusao($responsavel);

        $dto = $this->factory->createDtoFromEntity($ferias);

        $this->assertInstanceOf(FeriasDTO::class, $dto);
        $this->assertEquals(99, $dto->id);
        $this->assertEquals(1, $dto->funcionarioId);
        $this->assertEquals(2, $dto->userInclusaoId);
        $this->assertEquals('2025-01-01', $dto->dataInicio);
        $this->assertEquals('2025-01-15', $dto->dataFim);
    }
}
