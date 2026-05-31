<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Collection;

class Response {

    private string|null $message = null; 
    private array|Collection|null $data = null; 
    private bool $status; 
    private int|null $code = null; 

    private function __construct(bool $status, ?string $message, array|Collection|null $data, ?int $code) {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
        $this->code = $code;
    }

    private function __clone() {}

    public static function getResponse(bool $status, ?string $message = null, array|Collection|null $data = null, ?int $code = null) {
        return new Response($status, $message, $data, $code);
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getData(): array|Collection|null
    {
        return $this->data;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }
}