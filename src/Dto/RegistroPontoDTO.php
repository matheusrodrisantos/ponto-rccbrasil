<?php

namespace App\Dto;

use DateTime;
use App\Entity\Funcionario;
use DateTimeInterface;

class RegistroPontoDTO
{

    public ?int $id = null;
    public ?int $funcionarioId = null;
    public ?Funcionario $funcionario = null;
    public ?string $horaBatida = null;
    public ?DateTimeInterface $data = null;
    public ?array $batidasPonto = null;

    public ?string $entrada = null;
    public ?string $saida = null;
}
