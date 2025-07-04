<?php

namespace App\Dto\Departamento;

interface DepartamentoInterfaceDTO
{
    public function getId(): ?int;
    public function getNome(): ?string;
    public function getDescricao(): ?string;
    public function getSupervisorId(): ?int;
    public function getAtivo(): ?bool;
}
