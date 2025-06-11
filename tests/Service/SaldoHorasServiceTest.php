<?php
namespace App\Tests\Service;

use App\Entity\Departamento;
use App\Entity\Funcionario;
use App\Entity\ValueObject\Cpf;
use App\Entity\ValueObject\Email;
use App\Entity\ValueObject\Jornada;
use App\Service\SaldoHorasService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SaldoHorasServiceTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private SaldoHorasService $saldoHorasService;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = self::$kernel
            ->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->saldoHorasService = static::getContainer()->get(SaldoHorasService::class);
    }

    public function testCalcularSaldoHoras(): void
    {
        $jornada     = new Jornada('08:00:00', '44:00:00');
        $cpf         = new Cpf('43523797861');
        $email       = new Email('matheys.rosds@gemco.com');
        $funcionario = new Funcionario($jornada, $cpf, $email);
        $funcionario->setNome('João');
        $funcionario->setAtivo(true);

        $departamento = new Departamento();
        $departamento->setNome('TI');
        $departamento->setAtivo(true);

        $funcionario->setDepartamento($departamento);

        $this->entityManager->persist($departamento);
        $this->entityManager->persist($funcionario);
        $this->entityManager->flush();

        $saldoHoras = $this->saldoHorasService->calcularSaldoHoras($funcionario);

        $this->assertIsFloat($saldoHoras);
        $this->assertEquals(0.0, $saldoHoras);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        unset($this->entityManager, $this->saldoHorasService);
    }
}
