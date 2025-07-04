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

        $saldoHoras->adicionarHorasTrabalhadas(horasTrabalhadas: $registroPonto->saldoPeriodo());

        $saldoHoras->ajustarData(data: $registroPonto->data());

        $saldoHoras->atribuirFuncionario(funcionario: $registroPonto->funcionario());

        $saldoHoras = $this->calculoSaldoService->calcular(saldoHoras: $saldoHoras);

        $this->saldoHorasRepository->create(saldoHoras: $saldoHoras);
    }
}
