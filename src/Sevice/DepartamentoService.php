<?php

namespace App\Sevice;

use App\Dto\DepartamentoDTO;
use App\Entity\Departamento;
use App\Factory\DepartamentoFactory;
use App\Repository\DepartamentoRepository;


class DepartamentoService{

    private Departamento $dpto;
    
    public function __construct(
        private DepartamentoRepository $departamentoRepository,
        private DepartamentoFactory $departamentoFactory
    ){}

    public function createEntity(DepartamentoDTO $dptoDto):DepartamentoDTO{

        $this->dpto = $this->departamentoFactory->createFromDto($dptoDto);

        $this->departamentoRepository->create($this->dpto);

        return $this->departamentoFactory->createDtoFromEntity($this->dpto);
    }

}