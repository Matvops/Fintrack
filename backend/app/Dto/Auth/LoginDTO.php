<?php

namespace App\Dto\Auth;

use JsonSerializable;

readonly class LoginDTO implements JsonSerializable {

    public function __construct(
        public string $email,
        public string $password,
    ){}

    public static function fromArray(array $dados): self
    {
        return new self(
            email: $dados['email'],
            password: $dados['password'],
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

    public function jsonSerialize(): mixed 
    {
        return [
            'email' => $this->email,
            'password' => '******'
        ];
    }
}