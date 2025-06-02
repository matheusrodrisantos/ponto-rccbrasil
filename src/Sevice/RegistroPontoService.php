<?php

namespace App\Sevice;

use App\Dto\RegistroPontoDTO;
use App\Entity\RegistroPonto;
use App\Entity\ValueObject\BatidaPonto;
use App\Event\EventPublisher;
use App\Event\PontoCompletoEvent;
use App\Exception\RegraDeNegocioFuncionarioException;
use App\Factory\RegistroPontoFactory;
use App\Repository\FuncionarioRepository;
use App\Repository\RegistroPontoRepository;
use DateTimeImmutable;
use DateTimeZone;

class RegistroPontoService
{

    public function __construct(
        private RegistroPontoRepository $registroPontoRepository,
        private FuncionarioRepository $funcionarioRepository,
        private RegistroPontoFactory $registroPontoFactory,
        private EventPublisher $eventPublisher
    ) {}

    public function registrar(int $funcionarioID): RegistroPontoDTO
    {
        // TODO: Substituir busca por ID direto por busca baseada no usuário autenticado.
        //uma regra tem que ter um funcionario e ele deve estar ativo
        $funcionario = $this->funcionarioRepository->buscarFuncionarioAtivoPorId(id: $funcionarioID);

        if ($funcionario == null) {
            throw new RegraDeNegocioFuncionarioException("Funcionario não encontrado");
        }

        $dataHora = new DateTimeImmutable(
            timezone: new DateTimeZone("America/Sao_Paulo")
        );

        $registroPonto = $this->registroPontoRepository->procurarPorPontoAberto($dataHora, $funcionario);
        
        if ($registroPonto == null || $registroPonto->pontoCompleto()) {
            if ($registroPonto->pontoCompleto() !== null) {
                $registroPonto->adicionarEventoDeDominio(new PontoCompletoEvent($registroPonto));
                $this->eventPublisher->publish($registroPonto);
            }

            $batidaHora = new BatidaPonto();
            $registroPonto = new RegistroPonto(batidaPonto: $batidaHora);
            $registroPonto->atribuirFuncionario($funcionario);
        }

        //uma regra é que o funcionario não pode bater mais de 10:00:00
        $registroPonto->baterPonto(dataHora: $dataHora);

        $this->registroPontoRepository->create($registroPonto);

        $dto = $this->registroPontoFactory->createDto($registroPonto);

        return $dto;
    }
}
