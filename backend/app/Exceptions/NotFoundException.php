<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception {


    function __construct(string $message = "Não encontrado", int $code = 404)
    {
        return parent::__construct($message, $code);
    }
}