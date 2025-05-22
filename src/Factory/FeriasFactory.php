<?php

namespace App\Factory;

use App\Entity\Ferias;
use App\Entity\Funcionario;
use App\Entity\ValueObject\DataFerias;
use App\Dto\FeriasDTO;
use App\Repository\FuncionarioRepository;

class FeriasFactory
{
    public function __construct(
        private FuncionarioRepository $funcionarioRepository    
    ){}

    


}
