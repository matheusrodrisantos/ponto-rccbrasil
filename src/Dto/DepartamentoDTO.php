<?php

namespace App\Dto;

class DepartamentoDTO
{
    public ?int $id = null;
    public ?string $nome = null;
    public ?string $descricao = null;
    public ?int $supervisorId = null;
    public ?bool $ativo = null;

    public function __construct(
        ?int $id = null,
        ?string $nome = null,
        ?string $descricao = null,
        ?int $supervisorId = null,
        ?bool $ativo = null
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->supervisorId = $supervisorId;
        $this->ativo = $ativo;
    }
}
