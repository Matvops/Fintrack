<?php

namespace App\Dto\User;

use App\Models\User;

readonly class UserDTO {

    public function __construct(
        public int $id,
        public string $email,
        public string $name
    ){}

    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->use_id,
            email: $user->use_email,
            name: $user->use_name
        );
    }

    public function toArray(): array 
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name
        ];
    }
}