<?php

namespace App\Service\RegrasDepartamento;

use App\Dto\DepartamentoDTO;
use App\Dto\DepartamentoInputDTO;
use App\Dto\DepartamentoInterfaceDTO;

class ExecutorCadeiaRegrasDepartamento
{

    /**
     * @var RegrasDepartamentoInterface[]
     */
    private array $regras = [];

    public function __construct(iterable $regras = [])
    {
        foreach ($regras as $regra) {
            $this->adicionarRegra($regra);
        }
    }

    public function adicionarRegra(RegrasDepartamentoInterface $regra): void
    {
        $this->regras[] = $regra;
    }

    public function validar(DepartamentoInterfaceDTO $dto): void
    {
        foreach ($this->regras as $regra) {
            $regra->validar($dto);
        }
    }
}
