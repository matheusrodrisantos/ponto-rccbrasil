<?php

namespace App\Service;

use App\Entity\Funcionario;
use App\Entity\RegistroPonto;
use App\Entity\SaldoHoras;
use App\Repository\SaldoHorasRepository;

class SaldoHorasService
{
    public function __construct(
        private Funcionario $funcionario,
        private SaldoHoras $saldoHoras,
        private SaldoHorasRepository $saldoHorasRepository
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
        
        $jornadaDiariaSegundos = $saldoHoras->jornadaDiariaSegundosFuncionario();
        
        //TODO implementar regra de calculo de saldo de horas chain of responsibility
        $saldoHoras->recalcularSaldo($jornadaDiariaSegundos);

        $this->saldoHorasRepository->create($saldoHoras);
    }
}
