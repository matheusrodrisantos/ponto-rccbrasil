<?php

namespace App\Entity;

use App\Repository\FeriasRepository;
use App\Entity\ValueObject\DataFerias;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeriasRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Ferias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ferias')]
    private ?Funcionario $funcionario = null;

    #[ORM\ManyToOne]
    private ?Funcionario $userInclusao = null;

    #[ORM\Embedded(DataFerias::class,false)]
    private ?DataFerias $dataFerias =null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct(DataFerias $dataFerias)
    {   
        $this->dataFerias=$dataFerias;
    }

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

    public function getDataIni(): ?\DateTimeImmutable
    {
        return $this->dataFerias->getDataIni();
    }

    public function getDataFim(): ?\DateTimeImmutable
    {
        return $this->dataFerias->getDataFim();
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

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function setUpadteAtValue(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
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
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $UpdatedAt): static
    {
        $this->updatedAt = $UpdatedAt;

        return $this;
    }
}
