<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception {


    function __construct(string $message = "Erro de validação", int $code = 0)
    {
        return parent::__construct($message, $code);
    }
}