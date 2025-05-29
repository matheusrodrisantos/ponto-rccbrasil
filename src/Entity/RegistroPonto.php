<?php

namespace App\Entity;

use App\Repository\RegistroPontoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Enum\StatusRegistroPonto;
use App\Entity\trait\TimestampableTrait;
use App\Entity\ValueObject\BatidaPonto;
use DateTime;
use DateTimeImmutable;

#[ORM\Entity(repositoryClass: RegistroPontoRepository::class)]
#[ORM\HasLifecycleCallbacks]
class RegistroPonto
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'registroPontos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Funcionario $funcionario = null;

    #[ORM\Embedded(BatidaPonto::class, false)]
    private ?BatidaPonto $batidaPonto = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $data = null;

    public function __construct(BatidaPonto $batidaPonto)
    {
        $this->batidaPonto = $batidaPonto;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function funcionario(): ?Funcionario
    {
        return $this->funcionario;
    }

    public function baterPonto(DateTimeImmutable $hora): void
    {
        $this->batidaPonto = $this->batidaPonto->registrar($hora);
    }

    public function pontoCompleto(): bool
    {
        return $this->batidaPonto->completo();
    }

    public function entrada(): ?string
    {

        return $this->batidaPonto?->entrada();
    }

    public function saida(): ?string
    {
        return $this->batidaPonto?->saida();
    }

    public function atribuirFuncionario(?Funcionario $funcionario): static
    {
        if ($funcionario === null) {
            throw new \InvalidArgumentException('Funcionário não pode ser nulo');
        }

        $this->funcionario = $funcionario;

        return $this;
    }

    public function data(): ?\DateTime
    {
        return $this->data;
    }

    public function ajustarDataPonto(\DateTime $data): static
    {
        $this->data = $data;

        return $this;
    }
}
