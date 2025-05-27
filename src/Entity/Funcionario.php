<?php

namespace App\Entity;

use App\Entity\Enum\Regime;
use App\Entity\Enum\Funcao;
use App\Entity\ValueObject\Jornada;
use App\Entity\ValueObject\Email;
use App\Entity\ValueObject\Cpf;

use App\Repository\FuncionarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Serializer\Annotation\Ignore;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FuncionarioRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_FUNCIONARIO_CPF', columns: ['cpf'])]
class Funcionario 
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Embedded(class: Cpf::class, columnPrefix:false)]
    private ?Cpf $cpf = null;

    #[ORM\Embedded(class: Email::class, columnPrefix:false)]
    private ?Email $email = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Embedded(class: Jornada::class, columnPrefix:false)]
    private ?Jornada $jornada = null;

    #[ORM\Column(enumType: Regime::class)]
    private ?Regime $regime = null;

    #[ORM\Column(enumType: Funcao::class)]
    private ?Funcao $funcao = null;

    #[ORM\Column]
    private ?bool $verificar_localizacao = null;

    #[ORM\Column]
    private ?bool $ativo = null;

    /**
     * @var Collection<int, Ferias>
     */
    #[Ignore]
    #[ORM\OneToMany(targetEntity: Ferias::class, mappedBy: 'funcionario')]
    private Collection $ferias;

    /**
     * @var Collection<int, RegistroPonto>
     */
    #[ORM\OneToMany(targetEntity: RegistroPonto::class, mappedBy: 'funcionario')]
    private Collection $registroPontos;

    /**
     * @var Collection<int, SaldoHoras>
     */
    #[ORM\OneToMany(targetEntity: SaldoHoras::class, mappedBy: 'funcionario')]
    private Collection $saldoHoras;

    #[ORM\ManyToOne(targetEntity:Departamento::class, inversedBy: 'funcionarios')]
    private ?Departamento $departamento = null;

    #[ORM\OneToOne(mappedBy: 'supervisor', targetEntity: Departamento::class)]
    private ?Departamento $departamentoSupervisionado = null;

    public function __construct(
        Jornada $jornada,
        Cpf $cpf, 
        Email $email
    )
    {
        $this->ferias = new ArrayCollection();
        $this->registroPontos = new ArrayCollection();
        $this->saldoHoras = new ArrayCollection();

        $this->jornada=$jornada;
        $this->cpf=$cpf;
        $this->email=$email;
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }


    public function getEmail(): ?Email
    {
        return $this->email;
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

    public function getJornada(): Jornada
    {
        return $this->jornada;
    }


    public function getJornadaDiaria(): string
    {
        return $this->jornada->getJornadaDiaria();
    }

    public function getJornadaSemanal(): string
    {
        return $this->jornada->getJornadaSemanal();
    }


    public function getRegime(): ?Regime
    {
        return $this->regime;
    }

    public function setRegime(Regime $regime): static
    {
        $this->regime = $regime;

        return $this;
    }

    public function isVerificarLocalizacao(): ?bool
    {
        return $this->verificar_localizacao;
    }

    public function setVerificarLocalizacao(bool $verificar_localizacao): static
    {
        $this->verificar_localizacao = $verificar_localizacao;

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
     * @return Collection<int, Ferias>
     */
    public function getFerias(): Collection
    {
        return $this->ferias;
    }

    public function addFeria(Ferias $feria): static
    {
        if (!$this->ferias->contains($feria)) {
            $this->ferias->add($feria);
            $feria->definirFuncionario($this);
        }

        return $this;
    }
    
    public function removeFeria(Ferias $feria): static
    {
        if ($this->ferias->removeElement($feria)) {
            // set the owning side to null (unless already changed)
            if ($feria->funcionario() === $this) {
                $feria->definirFuncionario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RegistroPonto>
     */
    public function getRegistroPontos(): Collection
    {
        return $this->registroPontos;
    }

    public function addRegistroPonto(RegistroPonto $registroPonto): static
    {
        if (!$this->registroPontos->contains($registroPonto)) {
            $this->registroPontos->add($registroPonto);
            $registroPonto->setFuncionario($this);
        }

        return $this;
    }

    public function removeRegistroPonto(RegistroPonto $registroPonto): static
    {
        if ($this->registroPontos->removeElement($registroPonto)) {
            // set the owning side to null (unless already changed)
            if ($registroPonto->getFuncionario() === $this) {
                $registroPonto->setFuncionario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SaldoHoras>
     */
    public function getSaldoHoras(): Collection
    {
        return $this->saldoHoras;
    }

    public function addSaldoHora(SaldoHoras $saldoHora): static
    {
        if (!$this->saldoHoras->contains($saldoHora)) {
            $this->saldoHoras->add($saldoHora);
            $saldoHora->setFuncionario($this);
        }

        return $this;
    }

    public function removeSaldoHora(SaldoHoras $saldoHora): static
    {
        if ($this->saldoHoras->removeElement($saldoHora)) {
            // set the owning side to null (unless already changed)
            if ($saldoHora->getFuncionario() === $this) {
                $saldoHora->setFuncionario(null);
            }
        }

        return $this;
    }

    public function getDepartamento(): ?Departamento
    {
        return $this->departamento;
    }

    public function getDepartamentoId():?int
    {
        return $this->departamento?->getId();
    }


    public function getDepartamentoNome():?string
    {
        return $this->departamento?->getNome();
    }


    public function getDepartamentoDescricao():?string
    {
        return $this->departamento?->getDescricao();
    }

    public function setDepartamento(?Departamento $departamento): static
    {
        $this->departamento = $departamento;

        return $this;
    }

    public function getFuncao(): ?Funcao
    {
        return $this->funcao;
    }

    public function setFuncao(Funcao $funcao): static
    {
        $this->funcao = $funcao;

        return $this;
    }

    /**
     * Get the value of departamentoSupervisionado
     */ 
    public function getDepartamentoSupervisionado():?Departamento
    {
        return $this?->departamentoSupervisionado;
    }

    
    public function getDepartamentoSupervisionadoId():?int
    {
        return $this->departamentoSupervisionado?->getId();
    }

    public function temDepartamentoSupervisionado(): bool
    {
        return $this->departamentoSupervisionado !== null;
    }



    public function getDepartamentoSupervisionadoNome():?string
    {
        return $this->departamentoSupervisionado?->getNome();
    }
    /**
     * Set the value of departamentoSupervisionado
     *
     * @return  self
     */ 
    public function setDepartamentoSupervisionado(Departamento $departamentoSupervisionado)
    {
        $this->departamentoSupervisionado = $departamentoSupervisionado;

        return $this;
    }
}
