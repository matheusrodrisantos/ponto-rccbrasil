<?php
namespace App\Event;

use App\Entity\RegistroPonto;
use DateTimeImmutable;

class PontoCompletoEvent implements EventInterface{

    private DateTimeImmutable $ocorreuQuando;

    public function __construct(
        private readonly RegistroPonto $registroPonto
    ) {
        $this->ocorreuQuando = new DateTimeImmutable();
    }

    public function getRegistroPonto(): RegistroPonto
    {
        return $this->registroPonto;
    }

    public function ocorreuQuando(): DateTimeImmutable
    {
        return $this->ocorreuQuando;
    }
}