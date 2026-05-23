<?php

namespace App\Utils;

class Response {

    private string|null $message = null; 
    private array|null $data = null; 
    private bool $status; 
    private int|null $code = null; 

    private function __construct(bool $status, ?string $message, ?array $data, ?int $code) {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
        $this->code = $code;
    }

    private function __clone() {}

    public static function getResponse(bool $status, ?string $message = null, ?array $data = null, ?int $code = null) {
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

    public function getData(): ?array
    {
        return $this->data;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }
}