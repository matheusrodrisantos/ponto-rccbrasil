<?php

namespace App\Entity\ValueObject;

use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Jornada
{
    #[ORM\Column(name: 'jornada_diaria_segundos', type: 'integer')]
    private int $jornadaDiaria;

    #[ORM\Column(name: 'jornada_semanal_segundos', type: 'integer')]
    private int $jornadaSemanal;

    public function __construct(string $jornadaDiaria, string $jornadaSemanal)
    {
        $this->jornadaDiaria = $this->parseTimeToSeconds($jornadaDiaria);
        $this->jornadaSemanal = $this->parseTimeToSeconds($jornadaSemanal);
    }

    private function parseTimeToSeconds(string $time): int
    {
        if (!preg_match('/^(\d{1,3}):([0-5]?\d):([0-5]?\d)$/', $time, $matches)) {
            throw new InvalidArgumentException("Hora inválida: $time");
        }

        [$full, $hours, $minutes, $seconds] = $matches;
        return ((int)$hours * 3600) + ((int)$minutes * 60) + (int)$seconds;
    }

    private function formatSecondsToTime(int $seconds): string
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }

    public function getJornadaDiaria(): string
    {
        return $this->formatSecondsToTime($this->jornadaDiaria);
    }

    public function getJornadaSemanal(): string
    {
        return $this->formatSecondsToTime($this->jornadaSemanal);
    }

    public function getJornadaDiariaSegundos(): int
    {
        return $this->jornadaDiaria;
    }

    public function getJornadaSemanalSegundos(): int
    {
        return $this->jornadaSemanal;
    }
}
