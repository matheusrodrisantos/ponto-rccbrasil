<?php 
namespace App\Entity\ValueObject;

class DiaSemana
{
    private int $diaSemana;

    public function __construct(int $diaSemana)
    {
        if ($diaSemana < 0 || $diaSemana > 6) {
            throw new \InvalidArgumentException('Dia da semana deve ser entre 0 (Domingo) e 6 (Sábado).');
        }
        $this->diaSemana = $diaSemana;
    }

    public function getDiaSemana(): int
    {
        return $this->diaSemana;
    }

    public function isDomingo(): bool
    {
        return $this->diaSemana === 0;
    }

    public function isSabado(): bool
    {
        return $this->diaSemana === 6;
    }

    public static function hojeEhDomingo(): bool
    {
        return (new self((int) date('w')))->isDomingo();
    }

    public static function hojeEhSabado(): bool
    {
        return (new self((int) date('w')))->isSabado();
    }
}