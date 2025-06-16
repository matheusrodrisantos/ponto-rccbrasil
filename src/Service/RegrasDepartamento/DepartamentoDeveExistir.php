<?php

namespace App\Service\RegrasDepartamento;

use App\Dto\Departamento\DepartamentoInputDTO;
use App\Dto\Departamento\DepartamentoInterfaceDTO;
use App\Dto\Departamento\DepartamentoUpdateDTO;
use App\Exception\RegraDeNegocioDepartamentoException;
use App\Repository\DepartamentoRepository;

class DepartamentoDeveExistir implements RegrasDepartamentoInterface
{
    public function __construct(
        private readonly DepartamentoRepository $departamentoRepository
    ) {}

    public function validar(DepartamentoInterfaceDTO $departamento): void
    {

        if (!$this->departamentoRepository->find($departamento->getId())) {
            throw new RegraDeNegocioDepartamentoException(
                "Departamento com ID {$departamento->getId()} não existe."
            );
        }
    }
}
