<?php

namespace App\Sevice;

use App\Entity\RegistroPonto;
use App\Entity\ValueObject\BatidaPonto;
use App\Exception\RegraDeNegocioFuncionarioException;
use App\Factory\RegistroPontoFactory;
use App\Repository\FuncionarioRepository;
use App\Repository\RegistroPontoRepository;
use DateTime;
use DateTimeImmutable;

class RegistroPontoService
{

    public function __construct(
        private RegistroPontoRepository $registroPontoRepository,
        private FuncionarioRepository $funcionarioRepository,
        private RegistroPontoFactory $registroPontoFactory
    ) {}

    public function registrar(int $funcionarioID)
    {

        // TODO: Substituir busca por ID direto por busca baseada no usuário autenticado.

        $funcionario = $this->funcionarioRepository->find(id: $funcionarioID);

        if ($funcionario == null) {
            throw new RegraDeNegocioFuncionarioException("Funcionario não encontrado");
        }

        $dataHora = new DateTimeImmutable(
            datetime: "now",
            timezone: new \DateTimeZone("America/Sao_Paulo")
        );

        
        $registroPonto = $this->registroPontoRepository->procurarPorPontoAberto($dataHora, $funcionario);

        if ($registroPonto == null || $registroPonto->pontoCompleto()) {

            $batidaHora = new BatidaPonto();
            $registroPonto = new RegistroPonto(batidaPonto: $batidaHora);
            $registroPonto->atribuirFuncionario($funcionario);
        }

        $registroPonto->baterPonto(dataHora: $dataHora);

        $this->registroPontoRepository->create($registroPonto);

        $dto = $this->registroPontoFactory->createDto($registroPonto);


        return $dto;
    }
}
