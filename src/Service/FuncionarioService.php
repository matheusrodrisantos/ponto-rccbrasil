<?php

namespace App\Service;

use App\Dto\FuncionarioDTO;
use App\Entity\Funcionario;
use App\Exception\FuncionarioNotFoundException;
use App\Factory\FuncionarioFactory;
use App\Repository\FuncionarioRepository;
use App\Service\RegrasFuncionario\ExecutorRegrasFuncionario;
use App\Service\RegrasFuncionario\FuncionarioCpfUnico;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FuncionarioService
{

    private ?Funcionario $funcionario;

    public function __construct(
        private FuncionarioRepository $funcionarioRepository,
        private FuncionarioFactory $funcionarioFactory
    ) {}

    public function createEntity(FuncionarioDTO $funcDto): FuncionarioDTO
    {

        $executorRegrasFuncionario = new ExecutorRegrasFuncionario(regras: [
            new FuncionarioCpfUnico($this->funcionarioRepository)
        ]);

        $executorRegrasFuncionario->validar($funcDto);

        $this->funcionario = $this->funcionarioFactory->createFromDto($funcDto);

        $this->funcionarioRepository->create($this->funcionario);

        return $this->funcionarioFactory->createDtoFromEntity($this->funcionario);
    }

    public function listarFeriasFuncionario(int $id)
    {

        $this->funcionario = $this->funcionarioRepository->find($id);
    }

    public function detalhe(int $id): ?FuncionarioDTO
    {

        $this->funcionario = $this->funcionarioRepository->buscarFuncionarioAtivoPorId($id);

        if (!$this->funcionario) {
            throw new FuncionarioNotFoundException("Funcionário não encontrado ou inativo.");
        }

        return $this->funcionarioFactory->createDtoFromEntity($this->funcionario);
    }
}
