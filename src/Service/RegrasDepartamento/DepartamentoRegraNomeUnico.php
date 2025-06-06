<?php

namespace App\Service\RegrasDepartamento;

use App\Dto\DepartamentoDTO;
use App\Repository\DepartamentoRepository;
use App\Exception\RegraDeNegocioDepartamentoException;
use InvalidArgumentException;

class DepartamentoRegraNomeUnico implements RegrasDepartamentoInterface
{

    public function __construct(private DepartamentoRepository $departamentoRepository) {}

    public function validar(DepartamentoDTO $departamentoDTO): void
    {
        $departamento = $this->departamentoRepository->findOneBy(['nome' => $departamentoDTO->nome]);
        if ($departamento) {
            throw new RegraDeNegocioDepartamentoException(message: "Já
                 existe um departamento cadastrado com esse nome  
            ");
        }
    }
}
