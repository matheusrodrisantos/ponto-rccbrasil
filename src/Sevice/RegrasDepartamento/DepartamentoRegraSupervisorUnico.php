<?php

namespace App\Sevice\RegrasDepartamento;

use App\Dto\DepartamentoDTO;
use App\Repository\DepartamentoRepository;
use App\Exception\RegraDeNegocioDepartamentoException;

class DepartamentoRegraSupervisorUnico implements RegrasDepartamentoInterface{

    public function __construct(private DepartamentoRepository $departamentoRepository){}

    public function validar(DepartamentoDTO $dto): void
    {
        $departamento = $this->departamentoRepository->findOneBy(['supervisor' => $dto->supervisorId]);

        if ($departamento) {
            throw new RegraDeNegocioDepartamentoException("Este supervisor já está vinculado a outro departamento.");
        }
    }

}