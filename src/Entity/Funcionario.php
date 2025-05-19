<?php

namespace App\Entity;

use App\Entity\ValueObject\Jornada;
use App\Entity\ValueObject\Email;
use App\Entity\ValueObject\Cpf;

use App\Entity\Enum\Regime;
use App\Repository\FuncionarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: FuncionarioRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_FUNCIONARIO_CPF', columns: ['cpf'])]
class Funcionario implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Embedded(class: Cpf::class, columnPrefix:false)]
    private ?Cpf $cpf = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Embedded(class: Email::class, columnPrefix:false)]
    private ?Email $email = null;

    #[ORM\Column(length: 255)]
    private ?string $nome = null;

    #[ORM\Embedded(class: Jornada::class, columnPrefix:false)]
    private ?Jornada $jornada = null;

    #[ORM\Column(enumType: Regime::class)]
    private ?Regime $regime = null;

    #[ORM\Column]
    private ?bool $verificar_localizacao = null;

    #[ORM\Column]
    private ?bool $ativo = null;

    /**
     * @var Collection<int, Ferias>
     */
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->cpf;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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


    public function getRegime(): ?string
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
            $feria->setFuncionario($this);
        }

        return $this;
    }

    public function removeFeria(Ferias $feria): static
    {
        if ($this->ferias->removeElement($feria)) {
            // set the owning side to null (unless already changed)
            if ($feria->getFuncionario() === $this) {
                $feria->setFuncionario(null);
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

    public function setDepartamento(?Departamento $departamento): static
    {
        $this->departamento = $departamento;

        return $this;
    }


}
