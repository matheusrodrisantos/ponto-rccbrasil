<?php

namespace App\Sevice\RegrasFerias;

use App\Dto\FeriasDTO;

class CadeiaRegras
{

    private array $regras;

    public function __construct(array $regras)
    {
        $this->regras = $regras;
    }

    public function validar(FeriasDTO $dto): void
    {
        foreach ($this->regras as $regra) {
            $regra->validar($dto);
        }
    }
}
