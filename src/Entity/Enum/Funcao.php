<?php

namespace App\Entity\Enum;


enum Funcao: string
{
    case SUPERVISOR = 'SUPERVISOR';
    case RH = 'RH';
    case COLABORADOR = 'COLABORADOR';
    case GERENTE = 'GERENTE';
}
