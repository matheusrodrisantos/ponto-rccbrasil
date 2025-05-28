<?php
namespace App\Sevice\RegrasFuncionario;

use App\Dto\FuncionarioDTO;
use App\Exception\RegraDeNegocioFuncionarioException;
use App\Repository\FuncionarioRepository;

class FuncionarioCpfUnico implements FuncionarioRegrasInterface{

    public function __construct(private FuncionarioRepository $funcionarioRepository)
    {}

    public function validar(FuncionarioDTO $funcionarioDTO): void
    {
        if($this->funcionarioRepository->buscarCpf($funcionarioDTO->cpf)){
            throw new RegraDeNegocioFuncionarioException("Já existe um funcionário com este CPF");
        }
    }

}