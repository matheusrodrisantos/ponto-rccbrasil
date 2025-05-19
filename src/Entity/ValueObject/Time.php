<?php

namespace App\Entity\ValueObject;
use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

#[ORM\Embeddable]
final class Time
{
    #[ORM\Column(type: 'time')]
    private DateTimeImmutable $time;

    public function __construct(string $time)
    {
        $this->time = DateTimeImmutable::createFromFormat('H:i:s', $time)
            ?: DateTimeImmutable::createFromFormat('H:i', $time);

        if (!$this->time) {
            throw new InvalidArgumentException("Hora inválida: $time");
        }
    }

    public function format(string $format = 'H:i:s'): string
    {
        return $this->time->format($format);
    }

    public function equals(Time $other): bool
    {
        return $this->time == $other->time;
    }

    public function diffInMinutes(Time $other): int
    {
        $interval = $this->time->diff($other->time);
        return ($interval->h * 60) + $interval->i;
    }

    public function toDecimal(): float
    {
        return (int)$this->time->format('H') + ((int)$this->time->format('i') / 60);
    }

    public function addMinutes(int $minutes): Time
    {
        return new Time($this->time->modify("+{$minutes} minutes")->format('H:i:s'));
    }

    public function subMinutes(int $minutes): Time
    {
        return new Time($this->time->modify("-{$minutes} minutes")->format('H:i:s'));
    }

    public function getDateTime(): DateTimeImmutable
    {
        return $this->time;
    }
}
