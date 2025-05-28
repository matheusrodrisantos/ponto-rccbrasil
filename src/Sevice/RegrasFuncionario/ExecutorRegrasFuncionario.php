<?php
namespace App\Sevice\RegrasFuncionario;

use App\Dto\FuncionarioDTO;

class ExecutorRegrasFuncionario{
 
        /**
     * @var FuncionarioRegrasInterface[]
     */
    private array $regras = [];

    public function __construct(iterable $regras = [])
    {
        foreach ($regras as $regra) {
            $this->adicionarRegra($regra);
        }
    }

    public function adicionarRegra(FuncionarioRegrasInterface $regra): void
    {
        $this->regras[] = $regra;
    }

    public function validar(FuncionarioDTO $dto): void
    {
        foreach ($this->regras as $regra) {
            $regra->validar($dto);
        }
    }
}