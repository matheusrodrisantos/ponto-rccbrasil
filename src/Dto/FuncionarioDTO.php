<?php

namespace App\Dto;

use App\Dto\Departamento\DepartamentoOutputDTO;
use App\Entity\Enum\Funcao;
use App\Entity\Enum\Regime;

class FuncionarioDTO
{
    public function __construct(
        public ?int $id = null,
        public ?string $cpf = null,
        public ?int $departamentoId = null,
        public ?string $email = null,
        public ?string $nome = null,
        public ?string $jornadaDiaria = null,
        public ?string $jornadaSemanal = null,
        public ?Regime $regime = null,
        public ?Funcao $funcao = null,
        public ?bool $verificarLocalizacao = null,
        public ?bool $ativo = null,

        /**
         * @var FeriasDTO[]|null
         */
        public ?array $ferias = null,
        public ?array $registrosPonto = null,
        public ?array $saldoHoras = null,
        public ?DepartamentoOutputDTO $departamento = null
    ) {}
}
