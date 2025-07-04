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


    public ?string $entrada1 = null;
    public ?string $saida1 = null;
    public ?string $entrada2 = null;
    public ?string $saida2 = null;
    public ?string $entrada3 = null;
    public ?string $saida3 = null;
}
