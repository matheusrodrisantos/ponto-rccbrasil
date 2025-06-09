<?php

namespace App\Event;

use App\Event\PontoCompletoEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

use App\Repository\SaldoHorasRepository;
use App\Service\SaldoHorasService;

#[AsEventListener(event: PontoCompletoEvent::class, method: 'onPontoCompleto')]
class PontoCompletoListener
{

    public function __construct(
        private readonly SaldoHorasRepository $saldoHorasRepository,
        private SaldoHorasService $SaldoHoras
    ) {}

    public function onPontoCompleto(PontoCompletoEvent $event): void
    {
        $registroPonto = $event->getRegistroPonto();

        $this->SaldoHoras->calcular($registroPonto);
    }
}
