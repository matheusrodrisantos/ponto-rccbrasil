<?php

namespace App\Dto;

use App\Entity\Enum\Regime;

class FuncionarioDTO
{
    private ?int $id = null;
    private ?string $cpf = null;
    private array $roles = [];
    private ?string $password = null;
    private ?string $email = null;
    private ?string $nome = null;
    private ?string $jornadaDiaria = null;
    private ?string $jornadaSemanal = null;
    private ?Regime $regime = null;
    private ?bool $verificarLocalizacao = null;
    private ?bool $ativo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(?string $cpf): static
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(?string $nome): static
    {
        $this->nome = $nome;

        return $this;
    }

    public function getJornadaDiaria(): ?string
    {
        return $this->jornadaDiaria;
    }

    public function setJornadaDiaria(?string $jornadaDiaria): static
    {
        $this->jornadaDiaria = $jornadaDiaria;

        return $this;
    }

    public function getJornadaSemanal(): ?string
    {
        return $this->jornadaSemanal;
    }

    public function setJornadaSemanal(?string $jornadaSemanal): static
    {
        $this->jornadaSemanal = $jornadaSemanal;

        return $this;
    }

    public function getRegime(): ?Regime
    {
        return $this->regime;
    }

    public function setRegime(?Regime $regime): static
    {
        $this->regime = $regime;

        return $this;
    }

    public function isVerificarLocalizacao(): ?bool
    {
        return $this->verificarLocalizacao;
    }

    public function setVerificarLocalizacao(?bool $verificarLocalizacao): static
    {
        $this->verificarLocalizacao = $verificarLocalizacao;

        return $this;
    }

    public function isAtivo(): ?bool
    {
        return $this->ativo;
    }

    public function setAtivo(?bool $ativo): static
    {
        $this->ativo = $ativo;

        return $this;
    }
}