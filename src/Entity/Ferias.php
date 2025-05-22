<?php

namespace App\Entity;

use App\Repository\FeriasRepository;
use App\Entity\ValueObject\DataFerias;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

#[ORM\Entity(repositoryClass: FeriasRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Ferias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ferias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Funcionario $funcionario = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Funcionario $responsavelPelaInclusao = null;

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

    public function funcionario(): ?Int
    {
        return $this->funcionario->getId();
    }

    public function definirFuncionario(?Funcionario $funcionario): static
    {
        $this->funcionario = $funcionario;

        return $this;
    }

    public function responsavelPelaInclusao(): ?Int
    {
        return $this->responsavelPelaInclusao->getId();
    }

    public function definirResponsavelPelaInclusao(?Funcionario $usuario): static
    {
       if($this->funcionario===$usuario){
            throw new \InvalidArgumentException("O funcionário não pode registrar sua própria solicitação de férias.");
        }
        
        $this->responsavelPelaInclusao = $usuario;

        return $this;
    }

    public function dataDeInicio(): ?string
    {
        return $this->dataFerias->dataInicioFerias();
    }

    public function dataDeFim(): ?string
    {
        return $this->dataFerias->dataFimFerias();
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
}
