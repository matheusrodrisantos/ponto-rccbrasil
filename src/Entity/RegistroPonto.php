<?php

namespace App\Entity;

use App\Repository\RegistroPontoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegistroPontoRepository::class)]
class RegistroPonto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'registroPontos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Funcionario $funcionario = null;

    #[ORM\Column]
    private ?\DateTime $horaEntrada = null;

    #[ORM\Column]
    private ?\DateTime $horaSaida = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $data = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getHoraEntrada(): ?\DateTime
    {
        return $this->horaEntrada;
    }

    public function setHoraEntrada(\DateTime $horaEntrada): static
    {
        $this->horaEntrada = $horaEntrada;

        return $this;
    }

    public function getHoraSaida(): ?\DateTime
    {
        return $this->horaSaida;
    }

    public function setHoraSaida(\DateTime $horaSaida): static
    {
        $this->horaSaida = $horaSaida;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
