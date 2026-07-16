<?php

namespace App\Dto\Auth;

readonly class LoginDTO {

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
}