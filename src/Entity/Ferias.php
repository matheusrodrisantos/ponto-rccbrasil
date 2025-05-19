<?php

namespace App\Entity;

use App\Repository\FeriasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeriasRepository::class)]
class Ferias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $feriasId = null;

    #[ORM\ManyToOne(inversedBy: 'ferias')]
    private ?Funcionario $funcionario = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dataIni = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dataFim = null;

    #[ORM\ManyToOne]
    private ?Funcionario $userInclusao = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $UpdatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFeriasId(): ?int
    {
        return $this->feriasId;
    }

    public function setFeriasId(int $feriasId): static
    {
        $this->feriasId = $feriasId;

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

    public function getDataIni(): ?\DateTime
    {
        return $this->dataIni;
    }

    public function setDataIni(\DateTime $dataIni): static
    {
        $this->dataIni = $dataIni;

        return $this;
    }

    public function getDataFim(): ?\DateTime
    {
        return $this->dataFim;
    }

    public function setDataFim(\DateTime $dataFim): static
    {
        $this->dataFim = $dataFim;

        return $this;
    }

    public function getUserInclusao(): ?Funcionario
    {
        return $this->userInclusao;
    }

    public function setUserInclusao(?Funcionario $userInclusao): static
    {
        $this->userInclusao = $userInclusao;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $UpdatedAt): static
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }
}
