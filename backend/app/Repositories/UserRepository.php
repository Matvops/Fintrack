<?php

namespace App\Repositories;

use App\Dto\Auth\RegisterDTO;
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

    public function register(RegisterDTO $dto): User 
    {
        $user = new User();
        $user->use_name = $dto->name;
        $user->use_email = $dto->email;
        $user->use_password = bcrypt($dto->password);
        $user->save();

        return $user;
    }
}