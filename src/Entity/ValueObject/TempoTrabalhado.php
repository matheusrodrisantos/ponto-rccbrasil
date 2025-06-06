<?php
namespace App\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use DateInterval;
use DateTimeImmutable;

#[ORM\Embeddable]
class TempoTrabalhado{

    #[ORM\Column(type:'integer')]
    private int $segundos;

    public function __construct(int $segundos = 0)
    {
        $this->segundos = $segundos;
    }

    public function adicionar(DateInterval $interval): self
    {
        $base = new DateTimeImmutable();
        $end = $base->add($interval);
        $segundos = $end->getTimestamp() - $base->getTimestamp();
        return new self($this->segundos + $segundos);
    }

    public function alterar(int $valor):self {        
        return new self($valor);
    }


    public function subtrairSegundos(int $segundos): self
    {
        return new self($this->segundos - $segundos);
    }

    public function getSegundos(): int
    {
        return $this->segundos;
    }

    public function formatado(): string
    {
        $segundosAbsolutos = abs($this->segundos);

        $horas = floor($segundosAbsolutos / 3600);
        $minutos = floor(($segundosAbsolutos % 3600) / 60);
        $segundos = $segundosAbsolutos % 60;

        $sinal = $this->segundos < 0 ? '-' : '';

        return sprintf('%s%02d:%02d:%02d', $sinal, $horas, $minutos, $segundos);
    }

  
}