<?php

namespace App\Dto;

use App\Entity\Enum\Regime;

class FuncionarioDTO
{
   public function __construct(
       public ?int $id = null,
       public ?string $cpf = null,
       public ?int $departamentoId = null,
       public array $roles = [],
       public ?string $password = null,
       public ?string $email = null,
       public ?string $nome = null,
       public ?string $jornadaDiaria = null,
       public ?string $jornadaSemanal = null,
       public ?Regime $regime = null,
       public ?bool $verificarLocalizacao = null,
       public ?bool $ativo = null
    ) {
    }
}
