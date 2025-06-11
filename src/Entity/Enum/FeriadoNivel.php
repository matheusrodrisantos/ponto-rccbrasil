<?php

namespace App\Entity\Enum;


enum FeriadoNivel: string {
    case NACIONAL = 'NACIONAL';
    case ESTADUAL = 'ESTADUAL';
    case UNIVERSAL = 'UNIVERSAL';
    case MUNICIPAL = 'MUNICIPAL';
}
