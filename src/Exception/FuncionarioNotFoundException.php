<?php

namespace App\Exception;
use Exception;

class FuncionarioNotFoundException extends Exception
{
    public function __construct(string $message = "Funcionário não encontrado", int $code = 404)
    {
        parent::__construct($message, $code);
    }
}