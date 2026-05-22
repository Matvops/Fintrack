<?php

namespace App\Services;

use App\Models\User;

class AuthService {


    public function register(array $dados) {

        $user = new User();
        $user->use_name = $dados['name'];
        $user->use_email = $dados['email'];
        $user->use_password = bcrypt($dados['password']);
        $user->save();


        return 'Sucesso ao cadastrar';
    }
}