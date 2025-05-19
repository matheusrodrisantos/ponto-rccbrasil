<?php

namespace App\Sevice;

use App\Dto\FuncionarioDTO;
use App\Entity\Funcionario;
use App\Factory\FuncionarioFactory;
use App\Repository\FuncionarioRepository;

class FuncionarioService{

    private Funcionario $func;
    
    public function __construct(private FuncionarioRepository $funcionarioRepository)
    {}

    public function createEntity(FuncionarioDTO $funcDto):FuncionarioDTO{

        $this->func = FuncionarioFactory::createFromDto($funcDto);

        $this->funcionarioRepository->create($this->func);

        return FuncionarioFactory::createDtoFromEntity($this->func);

    }

}