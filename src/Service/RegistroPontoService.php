<?php

namespace App\Service;

use App\Dto\RegistroPontoDTO;
use App\Entity\Funcionario;
use App\Entity\RegistroPonto;
use App\Entity\ValueObject\BatidaPonto;
use App\Event\{EventPublisher, PontoCompletoEvent};
use App\Exception\FuncionarioNotFoundException;
use App\Exception\RegraDeNegocioFuncionarioException;
use App\Factory\RegistroPontoFactory;
use App\Repository\FuncionarioRepository;
use App\Repository\RegistroPontoRepository;
use App\Service\RegrasRegistroPonto\CadeiaRegrasRegistroPonto;
use App\Service\RegrasRegistroPonto\RegraFuncionarioBloqueadoNaoRegistraPonto;
use App\Service\RegrasRegistroPonto\RegraFuncionarioEmFeriasNaoRegistraPonto;
use DateTimeImmutable;

class RegistroPontoService
{

    public function __construct(
        private RegistroPontoRepository $registroPontoRepository,
        private FuncionarioRepository $funcionarioRepository,
        private RegistroPontoFactory $registroPontoFactory,
        private EventPublisher $eventPublisher
    ) {}

    public function registrar(int $funcionarioID): RegistroPontoDTO
    {   // TODO: Substituir busca por ID direto por busca baseada no usuário autenticado.
        //  uma regra tem que ter um funcionario e ele deve estar ativo
        $funcionario = $this->funcionarioRepository->buscarFuncionarioAtivoPorId(id: $funcionarioID);

        if ($funcionario == null) {
            throw new FuncionarioNotFoundException();
        }

        $this->aplicarRegrasNegocio(funcionario: $funcionario);

        $dataHora = new DateTimeImmutable();

        $registroPonto = $this->pegarOuCriarRegistroPonto(dataHora: $dataHora, funcionario: $funcionario);

        $batidaAnterior = $registroPonto->getBatidaPonto();

        $registroPonto->baterPonto(dataHora: $dataHora);

        $this->registroPontoRepository->create($registroPonto);

        if ($batidaAnterior->estavaAberto() && $registroPonto->pontoCompleto()) {
            $this->publicarEventoDePontoCompleto($registroPonto);
        }

        $dto = $this->registroPontoFactory->createDto($registroPonto);

        return $dto;
    }

    private function primeiroRegistroPontoDoDia(?RegistroPonto $registroPonto): bool
    {
        return $registroPonto == null;
    }

    private function periodoCompleto(?RegistroPonto $registroPonto): bool
    {
        return $registroPonto?->pontoCompleto();
    }

    private function inicializarPonto(Funcionario $funcionario): RegistroPonto
    {
        $batidaPonto = new BatidaPonto();
        $registroPonto = new RegistroPonto(batidaPonto: $batidaPonto);
        $registroPonto->atribuirFuncionario($funcionario);
        return $registroPonto;
    }

    private function publicarEventoDePontoCompleto(RegistroPonto $registroPonto): void
    {
        $registroPonto->adicionarEventoDeDominio(new PontoCompletoEvent($registroPonto));
        $this->eventPublisher->publish($registroPonto);
    }

    public function aplicarRegrasNegocio(Funcionario $funcionario): void
    {
        $cadeiaRegras = new CadeiaRegrasRegistroPonto(regras: [
            new RegraFuncionarioBloqueadoNaoRegistraPonto(),
            new RegraFuncionarioEmFeriasNaoRegistraPonto()
        ]);

        $cadeiaRegras->validar($funcionario);
    }

    private function pegarOuCriarRegistroPonto(DateTimeImmutable $dataHora, Funcionario $funcionario): RegistroPonto
    {
        $registroPonto = $this->registroPontoRepository->procurarPorPontoAberto($dataHora, $funcionario);

        if ($this->primeiroRegistroPontoDoDia($registroPonto) || $this->periodoCompleto($registroPonto)) {
            $registroPonto = $this->inicializarPonto($funcionario);
        }
        return $registroPonto;
    }
}
