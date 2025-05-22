<?php

namespace App\Dto;

use App\Entity\Enum\Regime;

class FuncionarioDTO
{
   public function __construct(
       public readonly ?int $id = null,
       public readonly ?string $cpf = null,
       public readonly ?int $departamentoId = null,
       public readonly array $roles = [],
       public readonly ?string $password = null,
       public readonly ?string $email = null,
       public readonly ?string $nome = null,
       public readonly ?string $jornadaDiaria = null,
       public readonly ?string $jornadaSemanal = null,
       public readonly ?Regime $regime = null,
       public readonly ?bool $verificarLocalizacao = null,
       public readonly ?bool $ativo = null, 
       
       public readonly ?array $ferias = null,
       public readonly ?array $registrosPonto = null,
       public readonly ?array $saldoHoras=null
    ) {
    }
}
