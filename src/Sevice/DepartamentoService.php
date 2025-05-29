<?php

namespace App\Sevice;

use App\Dto\DepartamentoDTO;
use App\Entity\Departamento;
use App\Factory\DepartamentoFactory;
use App\Repository\DepartamentoRepository;
use App\Sevice\RegrasDepartamento\DepartamentoRegraNomeUnico;
use App\Sevice\RegrasDepartamento\DepartamentoRegra;
use App\Sevice\RegrasDepartamento\DepartamentoRegraSupervisorUnico;
use App\Sevice\RegrasDepartamento\ExecutorCadeiaRegrasDepartamento;

class DepartamentoService
{

    private Departamento $dpto;

    public function __construct(
        private DepartamentoRepository $departamentoRepository,
        private DepartamentoFactory $departamentoFactory
    ) {}

    public function createEntity(DepartamentoDTO $dptoDto): DepartamentoDTO
    {

        $executorValidar = new ExecutorCadeiaRegrasDepartamento([
            (new DepartamentoRegraNomeUnico($this->departamentoRepository)),
            (new DepartamentoRegraSupervisorUnico($this->departamentoRepository))
        ]);

        $executorValidar->validar($dptoDto);

        $this->dpto = $this->departamentoFactory->createFromDto($dptoDto);

        $this->departamentoRepository->create($this->dpto);

        return $this->departamentoFactory->createDtoFromEntity($this->dpto);
    }
}
