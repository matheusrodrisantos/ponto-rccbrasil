<?php

namespace App\Event;

use App\Event\PontoCompletoEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

use App\Entity\SaldoHoras;
use App\Repository\SaldoHorasRepository;


#[AsEventListener(event: PontoCompletoEvent::class, method: 'onPontoCompleto')]
class PontoCompletoListener
{

    public function __construct(private readonly SaldoHorasRepository $saldoHorasRepository) {}

    public function onPontoCompleto(PontoCompletoEvent $event): void
    {
        $registroPonto = $event->getRegistroPonto();

        $saldoHoras  = $this->saldoHorasRepository->findOneBy(['data' => $registroPonto]);

        if ($saldoHoras == null) {
            $saldoHoras = new SaldoHoras();
        }

        $saldoHoras->adicionarSaldo($registroPonto->saldoPeriodo());
        dd($saldoHoras);
    }
}
