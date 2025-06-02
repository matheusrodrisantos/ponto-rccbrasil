<?php

namespace App\Entity\ValueObject;

use App\Exception\RegraDeNegocioFuncionarioException;
use App\Exception\RegraDeNegocioRegistroPontoException;
use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Embeddable]
class BatidaPonto
{

    #[ORM\Column(name: 'entrada', type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?DateTimeInterface $entrada;

    #[ORM\Column(name: 'saida', type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?DateTimeInterface $saida;

    private ?DateInterval $saldo = null;

    public function __construct(?DateTimeImmutable $entrada = null, ?DateTimeImmutable $saida = null)
    {
        if ($entrada && $saida && $entrada > $saida) {
            throw new RegraDeNegocioRegistroPontoException('A hora de entrada deve ser anterior à de saída.');
        }

        $this->entrada = $entrada;
        $this->saida = $saida;
    }

    public function registrar(DateTimeImmutable $hora): self
    {

        if ($this->entrada === null) {
            return new self($hora, $this->saida);
        }

        if ($this->saida === null) {
            if ($hora < $this->entrada) {
                throw new RegraDeNegocioRegistroPontoException('Saída não pode ser antes da entrada.');
            }
            return new self($this->entrada, $hora);
        }

        throw new RegraDeNegocioFuncionarioException("Ponto já está completo");
    }

    public function entrada(): ?string
    {
        return $this->entrada->format('H:i:s');
    }

    public function saida(): ?string
    {
        return $this->entrada->format('H:i:s');
    }

    public function completo(): bool
    {
        return $this->entrada !== null && $this->saida !== null;
    }

    public function calcularSaldo(): ?DateInterval
    {

        if ($this->entrada !== null && $this->saida !== null) {
            $this->saldo = $this->entrada->diff($this->saida);
        }

        return $this->saldo;
    }
    
}
