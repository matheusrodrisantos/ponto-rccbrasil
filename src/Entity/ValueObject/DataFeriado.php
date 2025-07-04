<?php

namespace App\Entity\ValueObject;

use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class DataFeriado
{
    #[ORM\Column(name: 'dia', type: 'integer')]
    public readonly int $dia;

    #[ORM\Column(name: 'mes', type: 'integer')]
    public readonly int $mes;

    public function __construct(\DateTimeImmutable $data)
    {
        $this->dia = (int)$data->format('d');
        $this->mes = (int)$data->format('m');
    }

    public function getDia(): int
    {
        return $this->dia;
    }

    public function getMes(): int
    {
        return $this->mes;
    }

    public function equals(DataFeriado $outro): bool
    {
        return $this->dia === $outro->dia && $this->mes === $outro->mes;
    }

    public function toDateTimeImmutable(int $ano = 1970): \DateTimeImmutable
    {
        return new \DateTimeImmutable(sprintf('%04d-%02d-%02d', $ano, $this->mes, $this->dia));
    }

    public function __toString(): string
    {
        $data = \DateTimeImmutable::createFromFormat('!d-m', $this->dia . '-' . $this->mes);
        $formatter = new \IntlDateFormatter('pt_BR', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);
        $formatter->setPattern('d \'de\' MMMM');

        return $formatter->format($data);
    }

    public function equalsDateTime(\DateTimeImmutable $data): bool
    {
        return $this->dia === (int)$data->format('d') && $this->mes === (int)$data->format('m');
    }

    public static function fromDiaMes(int $dia, int $mes): self
    {
        if (!checkdate($mes, $dia, 1970)) {
            throw new InvalidArgumentException("Data inválida: {$dia}/{$mes}");
        }

        $data = new \DateTimeImmutable(sprintf('1970-%02d-%02d', $mes, $dia));
        return new self($data);
    }
}
