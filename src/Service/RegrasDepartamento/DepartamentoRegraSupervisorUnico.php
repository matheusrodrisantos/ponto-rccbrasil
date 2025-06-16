<?php

namespace App\Service\RegrasDepartamento;

use App\Dto\DepartamentoDTO;
use App\Dto\DepartamentoInputDTO;
use App\Dto\DepartamentoInterfaceDTO;
use App\Repository\DepartamentoRepository;
use App\Exception\RegraDeNegocioDepartamentoException;

class DepartamentoRegraSupervisorUnico implements RegrasDepartamentoInterface
{

    public function __construct(private DepartamentoRepository $departamentoRepository) {}

    public function validar(DepartamentoInterfaceDTO $dto): void
    {
        if ($dto instanceof DepartamentoInputDTO && !$dto->supervisorId) {
            throw new \InvalidArgumentException("O DTO deve ser do tipo DepartamentoInputDTO.");
        }
        if($dto->supervisorId === null) {
            return; 
        }

        $departamento = $this->departamentoRepository->findOneBy(['supervisor' => $dto->supervisorId]);
        
        if ($departamento) {
            throw new RegraDeNegocioDepartamentoException("Este supervisor já está vinculado a outro departamento.");
        }
    }
}
