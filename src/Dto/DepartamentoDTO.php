<?php

namespace App\Dto;

use App\Entity\Funcionario;

class DepartamentoDTO{

    public ?int $id = null;
    public ?string $nome = null;
    public ?string $descricao = null;
    public ?Funcionario $supervisor = null;
    public ?bool $ativo = null;

    public function __construct(
        ?int $id = null,
        ?string $nome = null,
        ?string $descricao = null,
        ?Funcionario $supervisor = null,
        ?bool $ativo = null
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->supervisor = $supervisor;
        $this->ativo = $ativo;
    }
}