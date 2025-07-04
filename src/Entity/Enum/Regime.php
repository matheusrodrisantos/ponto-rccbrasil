<?php

namespace App\Entity\Enum;

enum Regime: string
{
    case PRESENCIAL = 'PRESENCIAL';
    case HIBRIDO = 'HIBRIDO';
    case HOME_OFFICE = 'HOME OFFICE';
}
