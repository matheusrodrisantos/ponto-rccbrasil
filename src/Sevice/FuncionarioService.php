<?php

namespace App\Sevice;

use App\Dto\FuncionarioDTO;
use App\Entity\Funcionario;
use App\Factory\FuncionarioFactory;
use App\Repository\FuncionarioRepository;

class FuncionarioService{

    private Funcionario $func;
    
    public function __construct(
        private FuncionarioRepository $funcionarioRepository,
        private FuncionarioFactory $funcionarioFactory
    ){}

    public function createEntity(FuncionarioDTO $funcDto):FuncionarioDTO{

        $this->func = $this->funcionarioFactory->createFromDto($funcDto);

        $this->funcionarioRepository->create($this->func);

        return $this->funcionarioFactory->createDtoFromEntity($this->func);

    }

}