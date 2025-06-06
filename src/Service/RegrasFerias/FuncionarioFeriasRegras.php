<?php

namespace App\Service\RegrasFerias;

use App\Dto\FeriasDTO;
use InvalidArgumentException;
use App\Repository\FuncionarioRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FuncionarioFeriasRegras implements RegrasFeriasInterface
{

    public function __construct(private FuncionarioRepository $funcionarioRepository) {}

    public function validar(FeriasDTO $ferias): void
    {

        if ($ferias->funcionarioId === null) {
            throw new InvalidArgumentException(message: 'Precisa de um funcionario');
        }

        $funcionario = $this->funcionarioRepository->find($ferias->funcionarioId);

        if (!$funcionario) {
            throw new NotFoundHttpException(message: "Funcionario com ID 
            {$ferias->funcionarioId} não encontrado.");
        }
    }
}
