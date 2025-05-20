<?php

namespace Tests\Factory;

use PHPUnit\Framework\TestCase;
use App\Factory\FeriasFactory;
use App\Entity\Ferias;
use App\Entity\Funcionario;
use App\Entity\ValueObject\DataFerias;
use App\Dto\FeriasDto;

class FeriasFactoryTest extends TestCase
{
    public function testCreateEntityFromDto()
    {
        $dto = new FeriasDto();
        $dto->dataIni = new \DateTimeImmutable('2024-01-01');
        $dto->dataFim = new \DateTimeImmutable('2024-01-10');
        $dto->createdAt = new \DateTimeImmutable('2024-01-01 10:00:00');
        $dto->updatedAt = new \DateTimeImmutable('2024-01-02 12:00:00');

        $funcionario = $this->createMock(Funcionario::class);
        $userInclusao = $this->createMock(Funcionario::class);

        $factory = new FeriasFactory();
        $ferias = $factory->createEntityFromDto($dto, $funcionario, $userInclusao);

        $this->assertInstanceOf(Ferias::class, $ferias);
        $this->assertEquals($dto->dataIni, $ferias->getDataIni());
        $this->assertEquals($dto->dataFim, $ferias->getDataFim());
        $this->assertSame($funcionario, $ferias->getFuncionario());
        $this->assertSame($userInclusao, $ferias->getUserInclusao());
        $this->assertEquals($dto->createdAt, $ferias->getCreatedAt());
        $this->assertEquals($dto->updatedAt, $ferias->getUpdatedAt());
    }

    public function testCreateDtoFromEntity()
    {
        $funcionario = $this->createMock(Funcionario::class);
        $funcionario->method('getId')->willReturn(1);
        $funcionario->method('getDepartamentoId')->willReturn(100); // necessário

        $userInclusao = $this->createMock(Funcionario::class);
        $userInclusao->method('getId')->willReturn(2);
        $userInclusao->method('getDepartamentoId')->willReturn(200); // necessário, se usado

        $dataIni = new \DateTimeImmutable('2024-01-01');
        $dataFim = new \DateTimeImmutable('2024-01-10');
        $createdAt = new \DateTimeImmutable('2024-01-01 10:00:00');
        $updatedAt = new \DateTimeImmutable('2024-01-02 12:00:00');

        $dataFerias = new DataFerias($dataIni, $dataFim);
        $ferias = $this->getMockBuilder(Ferias::class)
            ->setConstructorArgs([$dataFerias])
            ->onlyMethods(['getId', 'getFuncionario', 'getUserInclusao', 'getDataIni', 'getDataFim', 'getCreatedAt', 'getUpdatedAt'])
            ->getMock();

        $ferias->method('getId')->willReturn(10);
        $ferias->method('getFuncionario')->willReturn($funcionario);
        $ferias->method('getUserInclusao')->willReturn($userInclusao);
        $ferias->method('getDataIni')->willReturn($dataIni);
        $ferias->method('getDataFim')->willReturn($dataFim);
        $ferias->method('getCreatedAt')->willReturn($createdAt);
        $ferias->method('getUpdatedAt')->willReturn($updatedAt);

        $factory = new FeriasFactory();
        $dto = $factory->createDtoFromEntity($ferias);

        $this->assertInstanceOf(FeriasDto::class, $dto);
        $this->assertEquals(10, $dto->id);
        $this->assertEquals(1, $dto->funcionarioId);
        $this->assertEquals(2, $dto->userInclusaoId);
        $this->assertEquals($dataIni, $dto->dataIni);
        $this->assertEquals($dataFim, $dto->dataFim);
        $this->assertEquals($createdAt, $dto->createdAt);
        $this->assertEquals($updatedAt, $dto->updatedAt);
    }
}
