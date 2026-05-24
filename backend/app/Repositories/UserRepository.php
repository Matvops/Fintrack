<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {

    public function getUserByEmail(string $email): ?User
    {
        return User::where('use_email', $email)->first();
    }

    public function getUserById(int $id): ?User
    {
        return User::find($id);
    }
}