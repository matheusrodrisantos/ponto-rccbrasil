<?php

namespace App\Dto;

final readonly class FeriasDTO
{
    public ?int $id;
    public ?int $funcionarioId;
    public ?int $userInclusaoId;
    public ?string $dataInicio;
    public ?string $dataFim;

    public function __construct(
        ?int $funcionarioId=null,
        ?int $userInclusaoId=null,
        ?string $dataInicio=null,
        ?string $dataFim=null,
        ?int $id=null
    ) {
        $this->funcionarioId = $funcionarioId;
        $this->userInclusaoId = $userInclusaoId;
        $this->dataInicio = $dataInicio;
        $this->dataFim = $dataFim;
        $this->id = $id;
    }
}
