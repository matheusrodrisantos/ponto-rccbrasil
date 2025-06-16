<?php

namespace App\Service;

use App\Dto\DepartamentoInputDTO; // Changed
use App\Dto\DepartamentoOutputDTO; // Added
use App\Dto\DepartamentoUpdateDTO;
use App\Entity\Departamento;
use App\Exception\RegraDeNegocioDepartamentoException;
use App\Factory\DepartamentoFactory;
use App\Repository\DepartamentoRepository;
use App\Repository\FuncionarioRepository;
use App\Service\RegrasDepartamento\DepartamentoDeveExistir;
use App\Service\RegrasDepartamento\DepartamentoRegraNomeUnico;
// Ensure this namespace is correct if it was App\Service\RegrasDepartamento\DepartamentoRegra;
// use App\Service\RegrasDepartamento\DepartamentoRegra;
use App\Service\RegrasDepartamento\DepartamentoRegraSupervisorUnico;
use App\Service\RegrasDepartamento\ExecutorCadeiaRegrasDepartamento;

class DepartamentoService
{
    private Departamento $dpto; // Property name could be more generic if service handles more than one entity instance over time

    public function __construct(
        private DepartamentoRepository $departamentoRepository,
        private DepartamentoFactory $departamentoFactory,
        private FuncionarioRepository $funcionarioRepository
    ) {}

    // Changed parameter and return type
    public function createEntity(DepartamentoInputDTO $dptoDto): DepartamentoOutputDTO
    {
        $executorValidar = new ExecutorCadeiaRegrasDepartamento([
            (new DepartamentoRegraNomeUnico($this->departamentoRepository)),
            (new DepartamentoRegraSupervisorUnico($this->departamentoRepository))
        ]);

        $executorValidar->validar($dptoDto);

        $this->dpto = $this->departamentoFactory->createEntityFromInputDTO($dptoDto); // Changed factory call

        $this->departamentoRepository->create($this->dpto);

        return $this->departamentoFactory->createOutputDTOFromEntity($this->dpto); // Changed factory call
    }

    public function definirSupervisor(
        DepartamentoUpdateDTO $dptoUpdateDTO
    ): DepartamentoOutputDTO {

        $executorValidar = new ExecutorCadeiaRegrasDepartamento([
            (new DepartamentoRegraSupervisorUnico($this->departamentoRepository)),
            (new DepartamentoDeveExistir($this->departamentoRepository))
        ]);

        $executorValidar->validar($dptoUpdateDTO);

        $departamento = $this->departamentoRepository->find($dptoUpdateDTO->getId());

        $funcionario = $this->funcionarioRepository->find($dptoUpdateDTO->getSupervisorId());
        if (!$funcionario) {
            throw new RegraDeNegocioDepartamentoException("Funcionário com ID {$dptoUpdateDTO->getSupervisorId()} não encontrado.");
        }

        $departamento->setSupervisor($funcionario);

        $this->departamentoRepository->update($departamento);

        return $this->departamentoFactory->createOutputDTOFromEntity($departamento);
    }
}
