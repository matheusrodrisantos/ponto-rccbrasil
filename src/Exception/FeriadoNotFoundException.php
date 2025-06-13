<?php

namespace App\Exception;
use Exception;


class FeriadoNotFoundException extends Exception
{
    public function __construct(string $message = "Feriado não encontrado", int $code = 404)
    {
        parent::__construct($message, $code);
    }
}