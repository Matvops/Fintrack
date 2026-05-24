<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\User;
use App\Utils\Response;
use Exception;

class AuthService
{


    public function register(array $dados): Response
    {

        try {

            $this->validateEmail($dados['email']);

            $user = new User();
            $user->use_name = $dados['name'];
            $user->use_email = $dados['email'];
            $user->use_password = bcrypt($dados['password']);
            $user->save();

            return Response::getResponse(true, 'Usuário cadastrado com sucesso', code: 201);
        } catch (ValidationException $e) {
            return Response::getResponse(false, $e->getMessage(), code: 400);
        } catch(Exception $e) {
            return Response::getResponse(false, 'Erro ao criar usuário', code: $e->getCode());
        }
    }

    private function validateEmail(string $email): void 
    {
        if(substr_count($email, '@') !== 1) throw new ValidationException('Email inválido');

        $partsEmail = mb_split('@', $email);

        $needles = ['&', '=', '\'', '&', '<', '>', ','];

        foreach($needles as $needle) {
            if(str_contains($email, $needle)) throw new ValidationException('Email inválido');
        }

        $domain = $partsEmail[1];

        if(str_contains('..', $domain)) throw new ValidationException('Email inválido');
 
    }
}
