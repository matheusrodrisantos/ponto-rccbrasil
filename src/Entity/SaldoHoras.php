<?php

namespace App\Entity;

use App\Entity\trait\TimestampableTrait;
use App\Entity\ValueObject\TempoTrabalhado;
use App\Repository\SaldoHorasRepository;
use DateInterval;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaldoHorasRepository::class)]
#[ORM\HasLifecycleCallbacks]
class SaldoHoras
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Embedded(class: TempoTrabalhado::class, columnPrefix: 'horas_trabalhadas_')]
    private TempoTrabalhado $horasTrabalhadas;

    #[ORM\Embedded(class: TempoTrabalhado::class, columnPrefix: 'saldo_')]
    private TempoTrabalhado $saldo;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private string $obeservacao = '';

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $data = null;

    #[ORM\ManyToOne(inversedBy: 'saldoHoras')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Funcionario $funcionario = null;

    public function __construct()
    {
        $this->horasTrabalhadas = new TempoTrabalhado();
        $this->saldo = new TempoTrabalhado();
    }

    public function id(): ?int
    {
        return $this->id;
    }


    public function adicionarHorasTrabalhadas(DateInterval $horasTrabalhadas): static
    {
        $this->horasTrabalhadas = $this->horasTrabalhadas->adicionar($horasTrabalhadas);
        return $this;
    }

    public function adicionarHorasTrabalhadasSegundos(int $horasTrabalhadas): static
    {
        $this->horasTrabalhadas = $this->horasTrabalhadas->adicionarSegundos($horasTrabalhadas);
        return $this;
    }
    public function getHorasTrabalhadasSegundos(): int
    {
        return $this->horasTrabalhadas->getSegundos();
    }

    public function getHorasTrabalhadas(): TempoTrabalhado
    {
        return $this->horasTrabalhadas;
    }

    public function horasTrabalhadasFormatado(): string
    {
        return $this->horasTrabalhadas->formatado();
    }



    public function saldoFormatado(): string
    {
        return $this->saldo->formatado();
    }

    public function saldo(): TempoTrabalhado
    {
        return $this->saldo;
    }

    public function saldoFormatadoSegundos(): int
    {
        return $this->saldo->getSegundos();
    }

    public function recalcularSaldo(int $jornadaDiariaObrigatoria): static
    {
        $diferenca = $this->getHorasTrabalhadasSegundos() - $jornadaDiariaObrigatoria ;
        $this->saldo = $this->saldo->alterar($diferenca);
        return $this;
    }

    /** data do saldo  */
    public function data(): ?DateTimeImmutable
    {
        return $this->data;
    }

    public function ajustarData(DateTimeImmutable $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * funcionario  
     */
    public function funcionario(): ?Funcionario
    {
        return $this->funcionario;
    }

    public function atribuirFuncionario(?Funcionario $funcionario): static
    {
        $this->funcionario = $funcionario;

        return $this;
    }

    public function jornadaDiariaSegundosFuncionario(): ?int
    {
        if ($this->funcionario === null) {
            throw new \LogicException('Funcionario não atribuído ao saldo de horas.');
        }

        return $this->funcionario->jornadaDiariaSegundos();
    }

    public function setObeservacao(string $obeservacao): static
    {
        $this->obeservacao = $obeservacao;
        return $this;
    }
    
    public function obeservacao(): string
    {
        return $this->obeservacao;
    }
}
