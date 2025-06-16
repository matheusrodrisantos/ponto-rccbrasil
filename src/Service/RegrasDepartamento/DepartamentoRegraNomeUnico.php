<?php

namespace App\Service\RegrasDepartamento;

use App\Dto\Departamento\DepartamentoInterfaceDTO;
use App\Repository\DepartamentoRepository;
use App\Exception\RegraDeNegocioDepartamentoException;
use InvalidArgumentException;

class DepartamentoRegraNomeUnico implements RegrasDepartamentoInterface
{

    public function __construct(private DepartamentoRepository $departamentoRepository) {}

    public function validar(DepartamentoInterfaceDTO $departamentoDTO): void
    {
        $departamento = $this->departamentoRepository->findOneBy(['nome' => $departamentoDTO->getNome()]);
        if ($departamento) {
            throw new RegraDeNegocioDepartamentoException(message: "Já
                 existe um departamento cadastrado com esse nome  
            ");
        }
    }
}
