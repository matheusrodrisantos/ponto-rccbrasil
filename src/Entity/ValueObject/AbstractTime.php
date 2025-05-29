<?php

namespace App\Entity\ValueObject;

use DateTimeImmutable;
use InvalidArgumentException;

abstract class AbstractTime
{
    protected DateTimeImmutable $time;

    public function __construct(string $time)
    {
        $parsedTime = DateTimeImmutable::createFromFormat('H:i:s', $time)
            ?: DateTimeImmutable::createFromFormat('H:i', $time);

        $errors = DateTimeImmutable::getLastErrors();

        if (!$parsedTime || $errors['error_count'] > 0 || $errors['warning_count'] > 0) {
            throw new InvalidArgumentException("Hora inválida: $time");
        }

        $this->time = $parsedTime;
    }

    public function format(string $format = 'H:i:s'): string
    {
        return $this->time->format($format);
    }

    public function equals(self $other): bool
    {
        return $this->time == $other->time;
    }

    public function diffInMinutes(self $other): int
    {
        $interval = $this->time->diff($other->time);
        return ($interval->h * 60) + $interval->i;
    }

    public function toDecimal(): float
    {
        return (int)$this->time->format('H') + ((int)$this->time->format('i') / 60);
    }

    public function addMinutes(int $minutes): static
    {
        return new static($this->time->modify("+{$minutes} minutes")->format('H:i:s'));
    }

    public function subMinutes(int $minutes): static
    {
        return new static($this->time->modify("-{$minutes} minutes")->format('H:i:s'));
    }

    public function getDateTime(): DateTimeImmutable
    {
        return $this->time;
    }
}
