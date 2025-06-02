<?php

namespace App\Entity;

use App\Entity\trait\TimestampableTrait;
use App\Repository\SaldoHorasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaldoHorasRepository::class)]
class SaldoHoras
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $horasTrabalhadas = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $saldo = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $data = null;

    #[ORM\ManyToOne(inversedBy: 'saldoHoras')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Funcionario $funcionario = null;

    public function id(): ?int
    {
        return $this->id;
    }

    public function horasTrabalhadas(): ?\DateTimeImmutable
    {
        return $this->horasTrabalhadas;
    }

    public function ajustarHorasTrabalhadas(?\DateTimeImmutable $horasTrabalhadas): static
    {
        $this->horasTrabalhadas = $horasTrabalhadas;

        return $this;
    }

    public function saldoDiario(): ?\DateTimeImmutable
    {
        return $this->saldo;
    }

    public function ajustarSaldo(?\DateTimeImmutable $saldo): static
    {
        $this->saldo = $saldo;

        return $this;
    }

    public function adicionarSaldo(?\DateInterval $saldo): static
    {
        if ($this->saldo === null) {
            $this->saldo = new \DateTimeImmutable();
        }

        $this->saldo = $this->saldo->add($saldo);

        return $this;
    }

    public function saldoData(): ?\DateTimeImmutable
    {
        return $this->data;
    }

    public function ajustarData(\DateTimeImmutable $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function funcionario(): ?Funcionario
    {
        return $this->funcionario;
    }

    public function atribuirFuncionario(?Funcionario $funcionario): static
    {
        $this->funcionario = $funcionario;

        return $this;
    }
}
