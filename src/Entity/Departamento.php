<?php

namespace App\Entity;

use App\Entity\trait\TimestampableTrait;
use App\Repository\DepartamentoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartamentoRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Departamento
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descricao = null;

    #[ORM\OneToOne(targetEntity: Funcionario::class, inversedBy: 'departamentoSupervisionado')]
    #[ORM\JoinColumn(name: 'supervisor_id', referencedColumnName: 'id', nullable: true)]
    private ?Funcionario $supervisor = null;

    #[ORM\Column]
    private ?bool $ativo = null;

    /**
     * @var Collection<int, Funcionario>
     */
    #[ORM\OneToMany(targetEntity: Funcionario::class, mappedBy: 'departamento')]
    private Collection $funcionarios;

    public function __construct()
    {
        $this->funcionarios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): static
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getSupervisor(): ?Funcionario
    {
        return $this->supervisor;
    }

    public function setSupervisor(?Funcionario $supervisor): static
    {
        $this->supervisor = $supervisor;

        return $this;
    }

    public function isAtivo(): ?bool
    {
        return $this->ativo;
    }

    public function setAtivo(bool $ativo): static
    {
        $this->ativo = $ativo;

        return $this;
    }

    /**
     * @return Collection<int, Funcionario>
     */
    public function getFuncionarios(): Collection
    {
        return $this->funcionarios;
    }

    public function addFuncionario(Funcionario $funcionario): static
    {
        if (!$this->funcionarios->contains($funcionario)) {
            $this->funcionarios->add($funcionario);
            $funcionario->setDepartamento($this);
        }

        return $this;
    }

    public function removeFuncionario(Funcionario $funcionario): static
    {
        if ($this->funcionarios->removeElement($funcionario)) {
            // set the owning side to null (unless already changed)
            if ($funcionario->getDepartamento() === $this) {
                $funcionario->setDepartamento(null);
            }
        }

        return $this;
    }
}
