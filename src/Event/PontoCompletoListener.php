<?php

namespace App\Event;

use App\Event\PontoCompletoEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

use App\Entity\SaldoHoras;
use App\Repository\SaldoHorasRepository;
use App\Service\CalcularSaldoHoras;

#[AsEventListener(event: PontoCompletoEvent::class, method: 'onPontoCompleto')]
class PontoCompletoListener
{

    public function __construct(
        private readonly SaldoHorasRepository $saldoHorasRepository
    ) {}

    public function onPontoCompleto(PontoCompletoEvent $event): void
    {
        $registroPonto = $event->getRegistroPonto();
        
        $saldoHoras  = $this->saldoHorasRepository->findOneBy(['data' => $registroPonto->data()]);

        if ($saldoHoras == null) {
            $saldoHoras = new SaldoHoras();
        }
        
        $saldoHoras->adicionarHorasTrabalhadas($registroPonto->saldoPeriodo());
        $saldoHoras->ajustarData($registroPonto->data());
        $saldoHoras->atribuirFuncionario($registroPonto->funcionario());

        $jornadaDiariaSegundos = $saldoHoras->funcionario()->jornadaDiariaSegundos();
        
        $saldoHoras->recalcularSaldo($jornadaDiariaSegundos);

        $this->saldoHorasRepository->create($saldoHoras);
    }
}
