<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class PermissionDeniedException extends Exception {

    public function __construct(string $message = "Permissão negada", int $code = 403, Throwable|null $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}