<?php

namespace App\Service;

use App\Dto\Departamento\DepartamentoInputDTO; 
use App\Dto\Departamento\DepartamentoOutputDTO;
use App\Dto\Departamento\DepartamentoUpdateDTO;
use App\Entity\Departamento;

use App\Factory\DepartamentoFactory;
use App\Repository\DepartamentoRepository;
use App\Repository\FuncionarioRepository;
use App\Service\RegrasDepartamento\DepartamentoDeveExistir;
use App\Service\RegrasDepartamento\DepartamentoRegraNomeUnico;
use App\Service\RegrasDepartamento\DepartamentoRegraSupervisorUnico;
use App\Service\RegrasDepartamento\ExecutorCadeiaRegrasDepartamento;

use App\Exception\RegraDeNegocioDepartamentoException;
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

    public function removerSupervisor(
        DepartamentoUpdateDTO $dptoUpdateDTO
    ): DepartamentoOutputDTO {

        $executorValidar = new ExecutorCadeiaRegrasDepartamento([
            (new DepartamentoDeveExistir($this->departamentoRepository))
        ]);

        $executorValidar->validar($dptoUpdateDTO);

        $departamento = $this->departamentoRepository->find($dptoUpdateDTO->getId());

        $departamento->setSupervisor(null);

        $this->departamentoRepository->update($departamento);

        return $this->departamentoFactory->createOutputDTOFromEntity($departamento);
    }

    public function listarDepartamentos(): array
    {
        $departamentos = $this->departamentoRepository->findAll();
        return array_map(
            callback: fn(Departamento $dpto): DepartamentoOutputDTO => $this->departamentoFactory->createOutputDTOFromEntity($dpto),
            array: $departamentos
        );
    }
}
