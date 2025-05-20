<?php

namespace App\Dto;

use DateTime;
use DateTimeImmutable;

class FeriasDto
{
    public ?int $id = null;
    public ?int $feriasId = null;
    public ?int $funcionarioId = null;
    public ?DateTimeImmutable $dataIni = null;
    public ?DateTimeImmutable $dataFim = null;
    public ?int $userInclusaoId = null;
    public ?DateTimeImmutable $createdAt = null;
    public ?DateTimeImmutable $updatedAt = null;

    public function __construct(
        ?int $id = null,
        ?int $feriasId = null,
        ?int $funcionarioId = null,
        ?DateTime $dataIni = null,
        ?DateTime $dataFim = null,
        ?int $userInclusaoId = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null
    ) {
        $this->id = $id;
        $this->feriasId = $feriasId;
        $this->funcionarioId = $funcionarioId;
        $this->dataIni = $dataIni;
        $this->dataFim = $dataFim;
        $this->userInclusaoId = $userInclusaoId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
