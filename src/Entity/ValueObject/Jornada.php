<?php
namespace App\Entity\ValueObject;

use DateTimeImmutable;
use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Jornada
{
    #[ORM\Column(name: 'jornada_diaria', type: 'time')]
    private string $jornadaDiaria;

    #[ORM\Column(name: 'jornada_semanal', type: 'time')]
    private string $jornadaSemanal;

    public function __construct(string $jornadaDiaria, string $jornadaSemanal)
    {
        $this->jornadaDiaria = $this->validateHour($jornadaDiaria);
        $this->jornadaSemanal = $this->validateHour($jornadaSemanal);
    }

    private function validateHour(string $time): string
    {
        $parsedTime = DateTimeImmutable::createFromFormat('H:i:s', $time);
        $errors = DateTimeImmutable::getLastErrors();

        if (!$parsedTime || $errors['error_count'] > 0 || $errors['warning_count'] > 0) {
            throw new InvalidArgumentException("Hora inválida: $time");
        }

        return $parsedTime->format('H:i:s');
    }

    public function getJornadaDiaria(): string
    {
        return $this->jornadaDiaria;
    }

    public function getJornadaSemanal(): string
    {
        return $this->jornadaSemanal;
    }
}
