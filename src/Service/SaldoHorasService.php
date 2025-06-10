<?php

namespace App\Service;

use App\Entity\RegistroPonto;
use App\Entity\SaldoHoras;
use App\Repository\SaldoHorasRepository;

class SaldoHorasService
{
    public function __construct(
        private SaldoHorasRepository $saldoHorasRepository,
        private CalculoSaldoService $calculoSaldoService
    ) {}

    public function calcular(RegistroPonto $registroPonto): void
    {
        $saldoHoras  = $this->saldoHorasRepository->findOneBy(['data' => $registroPonto->data()]);

        if ($saldoHoras == null) {
            $saldoHoras = new SaldoHoras();
        }

        $saldoHoras->adicionarHorasTrabalhadas($registroPonto->saldoPeriodo());

        $saldoHoras->ajustarData($registroPonto->data());

        $saldoHoras->atribuirFuncionario($registroPonto->funcionario());

        $saldoHoras = $this->calculoSaldoService->calcular($saldoHoras);

        $this->saldoHorasRepository->create($saldoHoras);
    }
}
