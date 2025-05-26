<?php

namespace App\Tests\Repository;

use App\Entity\Funcionario;
use App\Entity\Departamento;
use App\Entity\Enum\Funcao;
use App\Tests\Helper\FakeFuncionarioTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FuncionarioRepositoryTest extends KernelTestCase
{
    use FakeFuncionarioTrait;

    private EntityManagerInterface $entityManager;
    private $repository;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = self::$kernel
            ->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->repository = $this->entityManager->getRepository(Funcionario::class);
    }

    public function testBuscarSupervisorAtivoRetornaSupervisorCorreto(): void
    {
        $supervisor = $this->criarFuncionario();

        $departamento = new Departamento();
        $departamento->setNome('TI');
        $departamento->setAtivo(true);

        $supervisor->setFuncao(Funcao::SUPERVISOR);
        $supervisor->setAtivo(true);
        $supervisor->setDepartamento($departamento);

        $departamento->setSupervisor($supervisor);

        $this->entityManager->persist($departamento);
        $this->entityManager->persist($supervisor);
        $this->entityManager->flush();

        $resultado = $this->repository->buscarSupervisorAtivo($supervisor->getId());

        $this->assertNotNull($resultado, 'Deve retornar um supervisor');
        $this->assertEquals($supervisor->getId(), $resultado->getId(), 'IDs devem coincidir');
        $this->assertEquals('TI', $resultado->getDepartamento()?->getNome(), 'Departamento deve ser TI');
    }

    public function testBuscarSupervisorAtivoNaoRetornaFuncionarioInativo(): void
    {
        $funcionario = $this->criarFuncionario();

        $departamento = new Departamento();
        $departamento->setNome('Financeiro');
        $departamento->setAtivo(true);

        $funcionario->setFuncao(Funcao::SUPERVISOR);
        $funcionario->setAtivo(false); // inativo
        $funcionario->setDepartamento($departamento);

        $departamento->setSupervisor($funcionario);

        $this->entityManager->persist($departamento);
        $this->entityManager->persist($funcionario);
        $this->entityManager->flush();

        $resultado = $this->repository->buscarSupervisorAtivo($funcionario->getId());

        $this->assertNull($resultado, 'Não deve retornar funcionário inativo');
    }

    public function testBuscarSupervisorAtivoSomenteSeForDoMesmoDepartamento(): void
    {
        // Supervisor A de Departamento A
        $supervisorA = $this->criarFuncionario();
        $supervisorA->setFuncao(Funcao::SUPERVISOR)->setAtivo(true);

        $departamentoA = new Departamento();
        $departamentoA->setNome('RH');
        $departamentoA->setSupervisor($supervisorA);
        $departamentoA->setAtivo(true);
        $supervisorA->setDepartamento($departamentoA);

        // Supervisor B de Departamento B
        $supervisorB = $this->criarFuncionario();
        $supervisorB->setFuncao(Funcao::SUPERVISOR)->setAtivo(true);

        $departamentoB = new Departamento();
        $departamentoB->setNome('TI');
        $departamentoB->setSupervisor($supervisorB);
        $departamentoB->setAtivo(true);

        $supervisorB->setDepartamento($departamentoB);

        $funcionario = $this->criarFuncionario();
        $funcionario->setAtivo(true);
        $funcionario->setDepartamento($departamentoA);

        $this->entityManager->persist($departamentoA);
        $this->entityManager->persist($departamentoB);
        $this->entityManager->persist($supervisorA);
        $this->entityManager->persist($supervisorB);
        $this->entityManager->persist($funcionario);
        $this->entityManager->flush();

        $resultado = $this->repository->buscarSupervisorAtivo($supervisorA->getId());

        $this->assertNotNull($resultado, 'Supervisor A deve ser retornado pois é do mesmo departamento');
        $this->assertEquals($departamentoA->getId(), $resultado->getDepartamento()?->getId());

        $resultadoErrado = $this->repository->buscarSupervisorAtivo($supervisorB->getId());

        $this->assertNotEquals($departamentoA->getId(), $resultadoErrado?->getDepartamento()?->getId(), 'Supervisor B não deve ser do mesmo departamento');
    }


    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        unset($this->entityManager);
    }
}
