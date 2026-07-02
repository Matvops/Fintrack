<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Logging\ErrorLogBuilder;
use App\Logging\InfoLogBuilder;
use App\Logging\LogInvoker;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Utils\Response;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthService
{

    private UserRepository $userRespository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRespository = $userRepository;
    }

    public function register(array $dados): Response
    {

        try {

            $this->validateEmail($dados['email']);

            if(password_verify($dados['confirmationPassword'], $dados['password'])) throw new ValidationException('As senhas não conferem');
            
            $user = new User();
            $user->use_name = $dados['name'];
            $user->use_email = $dados['email'];
            $user->use_password = bcrypt($dados['password']);
            $user->save();

            Auth::login($user);

            $data = [
                'id' => $user->use_id,
                'email' => $user->use_email,
                'name' => $user->use_name
            ];

            LogInvoker::register(new InfoLogBuilder)
                        ->withPayload($dados)
                        ->withResponse($data)
                        ->save('AUTH');

            return Response::getResponse(true, 'Usuário cadastrado com sucesso', data: $data, code: 201);
        } catch (ValidationException $e) {

            LogInvoker::register(new ErrorLogBuilder)
                        ->withPayload($dados)
                        ->save('AUTH', $e);

            return Response::getResponse(false, $e->getMessage(), code: 400);
        } catch(Exception $e) {

            LogInvoker::register(new ErrorLogBuilder)
                        ->withPayload($dados)
                        ->save('AUTH', $e);

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

    public function login(array $dados): Response
    {

        try {
            
            $email = $dados['email'];
            $password = $dados['password'];

            $user = $this->userRespository->getUserByEmail($email);

            if(!isset($user)) throw new ValidationException('E-mail ou senha inválidos');

            if(!password_verify($password, $user->use_password)) throw new ValidationException('E-mail ou senha inválidos');
            
            Auth::login($user);

            $data = [
                'id' => $user->use_id,
                'email' => $user->use_email,
                'name' => $user->use_name
            ];

            LogInvoker::login(new InfoLogBuilder)
                        ->withPayload($dados)
                        ->withResponse($data)
                        ->save('AUTH');

            return Response::getResponse(true, message: 'Login realizado com Sucesso!', data: $data);
        } catch(ValidationException $e) {

            LogInvoker::login(new ErrorLogBuilder)
                        ->withPayload($dados)
                        ->save('AUTH', $e);

            return Response::getResponse(false, message: $e->getMessage(), code: $e->getCode());
        } catch(Exception $e) {

            LogInvoker::login(new ErrorLogBuilder)
                        ->withPayload($dados)
                        ->save('AUTH', $e);

            return Response::getResponse(false, message: 'Error');
        }

    }

    public function logout(int $use_id) {

        try {

            $user = $this->userRespository->getUserById($use_id);

            if(!isset($user)) throw new ValidationException('Erro ao realizar login');

            Auth::logout();
            
            return Response::getResponse(true, 'Logout realizado com sucesso');
        } catch(Exception $e) {
            return Response::getResponse(false, 'Erro ao realizar Logout');
        }

    }
}
