<?php

namespace Tests\Factory;

use PHPUnit\Framework\TestCase;
use App\Factory\FeriasFactory;
use App\Entity\Ferias;
use App\Entity\Funcionario;
use App\Entity\ValueObject\DataFerias;
use App\Dto\FeriasDTO;
use DateTimeImmutable;

class FeriasFactoryTest extends TestCase
{
    public function testCreateEntityFromDto()
    {
        $dto = new FeriasDTO(
            id: null,
            funcionarioId: 1,
            userInclusaoId: 2,
            dataInicio: new DateTimeImmutable('2024-01-01')->format('Y-m-d'),
            dataFim: new DateTimeImmutable('2024-01-10')->format('Y-m-d'),
        );

        $funcionario = $this->createMock(Funcionario::class);
        $userInclusao = $this->createMock(Funcionario::class);

        $factory = new FeriasFactory();
        $ferias = $factory->createEntityFromDto($dto, $funcionario, $userInclusao);

        $this->assertInstanceOf(Ferias::class, $ferias);
        $this->assertEquals('2024-01-01', $ferias->dataDeInicio());
        $this->assertEquals('2024-01-10', $ferias->dataDeFim());
        $this->assertSame($funcionario, $ferias->funcionario());
        $this->assertSame($userInclusao, $ferias->responsavelPelaInclusao());
    }

    public function testCreateDtoFromEntity()
    {
        $funcionario = $this->createMock(Funcionario::class);
        $funcionario->method('getId')->willReturn(1);

        $userInclusao = $this->createMock(Funcionario::class);
        $userInclusao->method('getId')->willReturn(2);

        $dataIni = new \DateTimeImmutable('2024-01-01');
        $dataFim = new \DateTimeImmutable('2024-01-10');

        $dataFerias = new DataFerias($dataIni, $dataFim);
        $ferias = $this->getMockBuilder(Ferias::class)
            ->setConstructorArgs([$dataFerias])
            ->onlyMethods(['getId', 'funcionario', 'responsavelPelaInclusao', 'dataDeInicio', 'dataDeFim'])
            ->getMock();

        
        $ferias->method('getId')->willReturn(10);
        $ferias->method('funcionario')->willReturn($funcionario);
        $ferias->method('responsavelPelaInclusao')->willReturn($userInclusao);
        $ferias->method('dataDeInicio')->willReturn('2024-01-01');
        $ferias->method('dataDeFim')->willReturn('2024-01-10');

        $factory = new FeriasFactory();
        $dto = $factory->createDtoFromEntity($ferias);

        $this->assertInstanceOf(FeriasDTO::class, $dto);
        $this->assertEquals(10, $dto->id);
        $this->assertEquals(1, $dto->funcionarioId);
        $this->assertEquals(2, $dto->userInclusaoId);
        $this->assertEquals('2024-01-01', $dto->dataInicio);
        $this->assertEquals('2024-01-10', $dto->dataFim);
    }
}
