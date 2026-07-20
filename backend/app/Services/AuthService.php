<?php

namespace App\Services;

use App\Dto\Auth\LoginDTO;
use App\Dto\Auth\RegisterDTO;
use App\Dto\User\UserDTO;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Logging\ErrorLogBuilder;
use App\Logging\InfoLogBuilder;
use App\Logging\LogInvoker;
use App\Repositories\UserRepository;
use App\Utils\Functions;
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

    public function register(RegisterDTO $registerDTO): Response
    {

        try {

            Functions::validateEmail($registerDTO->email);

            if($registerDTO->confirmationPassword !== $registerDTO->password) throw new ValidationException('As senhas não conferem');
            
            $user = $this->userRespository->register($registerDTO);

            Auth::login($user);

            $userDTO = UserDTO::fromModel($user);

            LogInvoker::register(new InfoLogBuilder)
                        ->withPayload($registerDTO->jsonSerialize())
                        ->withResponse($userDTO)
                        ->save('AUTH');

            return Response::getResponse(true, 'Usuário cadastrado com sucesso', data: $userDTO->toArray(), code: 201);
        } catch (ValidationException $e) {
            LogInvoker::register(new ErrorLogBuilder)
                        ->withPayload($registerDTO->jsonSerialize())
                        ->save('AUTH', $e);

            return Response::getResponse(false, $e->getMessage(), code: 400);
        } catch(Exception $e) {

            LogInvoker::register(new ErrorLogBuilder)
                        ->withPayload($registerDTO->jsonSerialize())
                        ->save('AUTH', $e);

            return Response::getResponse(false, 'Erro ao criar usuário', code: $e->getCode());
        }
    }

    public function login(LoginDTO $loginDTO): Response
    {

        try {
            
            $email = $loginDTO->email;
            $password = $loginDTO->password;

            $user = $this->userRespository->getUserByEmail($email);

            if(!isset($user)) throw new ValidationException('E-mail ou senha inválidos');

            if(!password_verify($password, $user->use_password)) throw new ValidationException('E-mail ou senha inválidos');

            Auth::login($user);

            $userDTO = UserDTO::fromModel($user);

            LogInvoker::login(new InfoLogBuilder)
                        ->withPayload($loginDTO->jsonSerialize())
                        ->withResponse($userDTO)
                        ->save('AUTH');

            return Response::getResponse(true, message: 'Login realizado com Sucesso!', data: $userDTO->toArray());
        } catch(ValidationException $e) {

            LogInvoker::login(new ErrorLogBuilder)
                        ->withPayload($loginDTO->jsonSerialize())
                        ->save('AUTH', $e);

            return Response::getResponse(false, message: $e->getMessage(), code: $e->getCode());
        } catch(Exception $e) {

            LogInvoker::login(new ErrorLogBuilder)
                        ->withPayload($loginDTO->jsonSerialize())
                        ->save('AUTH', $e);

            return Response::getResponse(false, message: 'Error');
        }

    }

    public function logout(int $useId): Response
    {

        try {

            $user = $this->userRespository->getUserById($useId);

            if(!isset($user)) throw new NotFoundException('Usuário não encontrado');

            Auth::logout();
            
            return Response::getResponse(true, 'Logout realizado com sucesso');
        } catch(NotFoundException $e) {
            LogInvoker::logout(new ErrorLogBuilder)->withPayload(['id' => $useId])->save('AUTH', $e);
            return Response::getResponse(false, 'Erro ao realizar Logout');
        } catch(Exception $e) {
            LogInvoker::logout(new ErrorLogBuilder)->withPayload(['id' => $useId])->save('AUTH', $e);
            return Response::getResponse(false, 'Erro ao realizar Logout');
        }

    }

}
