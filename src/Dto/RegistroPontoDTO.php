<?php

namespace App\Dto;

use DateTime;
use App\Entity\Funcionario;


class RegistroPontoDTO
{

    public ?int $id = null;
    public ?Funcionario $funcionario = null;
    public ?string $batidaPonto = null;
    public ?DateTime $data = null;
    public ?array $batidasPonto = null;

    public ?string $entrada = null;
    public ?string $saida = null;
}
