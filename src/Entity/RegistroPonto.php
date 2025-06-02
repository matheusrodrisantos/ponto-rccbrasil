<?php

namespace App\Entity;

use App\Repository\RegistroPontoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\trait\TimestampableTrait;
use App\Entity\ValueObject\BatidaPonto;
use App\Event\EventInterface;
use DateInterval;
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

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $data = null;


    /** @var EventInterface[] */
    private array $domainEvents = [];

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

    public function baterPonto(DateTimeImmutable $dataHora): void
    {
        $this->batidaPonto = $this->batidaPonto->registrar($dataHora);
        $this->data = $dataHora;
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

    public function data(): ?DateTimeImmutable
    {
        return $this->data;
    }

    public function ajustarDataPonto(DateTimeImmutable $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function saldoPeriodo(): ?DateInterval
    {
        return $this->batidaPonto->calcularSaldo();
    }

    public function adicionarEventoDeDominio(EventInterface $event): void
    {
        $this->domainEvents[] = $event;
    }

    /**
     * @return EventInterface[]
     */
    public function releaseEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];
        return $events;
    }
}
