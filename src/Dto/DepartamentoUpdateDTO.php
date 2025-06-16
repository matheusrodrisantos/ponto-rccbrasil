<?php

namespace App\Dto;

class DepartamentoUpdateDTO implements DepartamentoInterfaceDTO
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

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNome(): ?string
    {
        return $this->nome;
    }
    public function getDescricao(): ?string
    {
        return $this->descricao;
    }
    public function getSupervisorId(): ?int
    {
        return $this->supervisorId;
    }
    public function getAtivo(): ?bool
    {
        return $this->ativo;
    }
}
