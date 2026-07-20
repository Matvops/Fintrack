<?php

namespace App\Dto\Auth;

use JsonSerializable;
use Override;

readonly class RegisterDTO implements JsonSerializable {

    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $confirmationPassword,
    )
    {}

    public static function fromArray(array $data): self 
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            confirmationPassword: $data['confirmationPassword'],
        );
    }

    public function toArray(): array 
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'confirmationPassword' => $this->confirmationPassword
        ];
    }

    public function jsonSerialize(): mixed
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => '*****',
            'confirmationPassword' => '*****'
        ];
    }
}