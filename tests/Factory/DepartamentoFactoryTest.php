<?php

namespace Tests\Factory;
use PHPUnit\Framework\TestCase;
use App\Dto\DepartamentoDTO;
use App\Entity\Departamento;
use App\Tests\Helper\FakeDepartamentoTrait;
use App\Tests\Helper\FakeFuncionarioTrait;

use App\Factory\DepartamentoFactory;

class DepartamentoFactoryTest extends TestCase
{
    use FakeFuncionarioTrait; 
    use FakeDepartamentoTrait;

    public function test_create_entity_from_dto()
    {
        $departamentoDto=$this->criarDepartamentoDto();
        $departamento=DepartamentoFactory::createFromDto($departamentoDto);
        $this->assertInstanceOf(Departamento::class, $departamento);
    }

    public function test_create_dto_from_entity(){
        $departamento=$this->criarDepartamento();
        $departamentoDto=DepartamentoFactory::createDtoFromEntity($departamento);
        $this->assertInstanceOf(DepartamentoDTO::class,$departamentoDto );

    }
}