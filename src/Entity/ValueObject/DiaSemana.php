<?php
namespace App\Entity\ValueObject;

use DateTimeInterface;
use InvalidArgumentException;

final class DiaSemana
{
    public const DIAS = [
        0 => 'domingo',
        1 => 'segunda',
        2 => 'terça',
        3 => 'quarta',
        4 => 'quinta',
        5 => 'sexta',
        6 => 'sábado',
    ];

    private readonly string $nome;

    public function __construct(DateTimeInterface $data)
    {
        $indice = (int) $data->format('w');

        if (! array_key_exists($indice, self::DIAS)) {
            throw new InvalidArgumentException("Dia da semana inválido: $indice");
        }

        $this->nome = self::DIAS[$indice];
    }

    public function nome(): string
    {
        return $this->nome;
    }

    /**
     * ehFimDeSemana
     *
     * @return bool
     */
    public function ehFimDeSemana(): bool
    {
        return in_array($this->nome, ['sábado', 'domingo'], true);
    }

    public function ehSabado(): bool
    {
        return $this->nome == "sábado";
    }

    /**
     * ehDomingo
     *
     * @return bool
     */
    public function ehDomingo(): bool
    {
        return $this->nome == "domingo";
    }

    public function ehDiaUtil(): bool
    {
        return ! $this->ehFimDeSemana();
    }

    public function igualA(DiaSemana $outro): bool
    {
        return $this->nome === $outro->nome;
    }

    public function __toString(): string
    {
        return $this->nome;
    }
}
