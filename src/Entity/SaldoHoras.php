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

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $horasTrabalhadas = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $saldo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $data = null;

    #[ORM\ManyToOne(inversedBy: 'saldoHoras')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Funcionario $funcionario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHorasTrabalhadas(): ?\DateTime
    {
        return $this->horasTrabalhadas;
    }

    public function setHorasTrabalhadas(?\DateTime $horasTrabalhadas): static
    {
        $this->horasTrabalhadas = $horasTrabalhadas;

        return $this;
    }

    public function getSaldo(): ?\DateTime
    {
        return $this->saldo;
    }

    public function setSaldo(?\DateTime $saldo): static
    {
        $this->saldo = $saldo;

        return $this;
    }

    public function getData(): ?\DateTime
    {
        return $this->data;
    }

    public function setData(\DateTime $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getFuncionario(): ?Funcionario
    {
        return $this->funcionario;
    }

    public function setFuncionario(?Funcionario $funcionario): static
    {
        $this->funcionario = $funcionario;

        return $this;
    }
}
