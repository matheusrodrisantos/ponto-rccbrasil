<?php

namespace App\Dto;

use DateTimeImmutable;
use DateTimeInterface;

final readonly class FeriasDTO
{
    public ?int $id;
    public int $funcionarioId;
    public int $userInclusaoId;
    public string $dataInicio;
    public string $dataFim;

    public function __construct(
        ?int $id,
        int $funcionarioId,
        int $userInclusaoId,
        string $dataInicio,
        string $dataFim,
    ) {
        $this->id = $id;
        $this->funcionarioId = $funcionarioId;
        $this->userInclusaoId = $userInclusaoId;
        $this->dataInicio = $dataInicio;
        $this->dataFim = $dataFim;
    }
}
