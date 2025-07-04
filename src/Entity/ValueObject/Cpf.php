<?php

namespace App\Entity\ValueObject;

use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Cpf
{
    #[ORM\Column(name: 'cpf', type: 'string', unique: true)]
    private string $cpf;

    public function __construct(string $cpf)
    {
        $this->ensureIsValidCpf($cpf);
        $this->cpf = $cpf;
    }

    private function ensureIsValidCpf(string $cpf): void
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            throw new InvalidArgumentException('Invalid CPF format.');
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                throw new InvalidArgumentException('Invalid CPF checksum.');
            }
        }
    }

    public function __toString(): string
    {
        return $this->cpf;
    }
}
