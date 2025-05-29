<?php

namespace App\Service\RegrasFerias;

use App\Dto\FeriasDTO;
use App\Repository\FuncionarioRepository;
use App\Sevice\RegrasFerias\RegrasFeriasInterface;
use InvalidArgumentException;

class SupervisorFeriasRegras implements RegrasFeriasInterface
{
    public function __construct(
        private FuncionarioRepository $funcionarioRepository
    ) {}

    public function validar(FeriasDTO $ferias): void
    {
        if ($ferias->userInclusaoId === null) {
            throw new InvalidArgumentException('Precisa de um supervisor que adicione');
        }

        $this->verificarPermissaoParaIncluirFerias($ferias->userInclusaoId, $ferias->funcionarioId);
    }

    private function verificarPermissaoParaIncluirFerias(int $userId, int $funcionarioId): void
    {
        $solicitante = $this->funcionarioRepository->buscarFuncionarioAtivoPorId($userId);

        if ($solicitante && in_array($solicitante->getFuncao()->value, ['GERENTE', 'RH'])) {
            return;
        }

        $supervisor = $this->funcionarioRepository->buscarSupervisorAtivo($userId);

        if ($supervisor === null) {
            throw new InvalidArgumentException(
                'Apenas supervisores do mesmo departamento, gerentes ou membros do RH podem incluir férias.'
            );
        }
        $departamentoSupervisorId = $supervisor->getDepartamentoSupervisionadoId();

        $funcionario = $this->funcionarioRepository->buscarFuncionarioAtivoPorId($funcionarioId);

        if (
            !$departamentoSupervisorId ||
            $departamentoSupervisorId !== $funcionario->getDepartamentoId()
        ) {

            throw new InvalidArgumentException(
                'Apenas supervisores do mesmo departamento, gerentes ou membros do RH podem incluir férias.'
            );
        }
    }
}
