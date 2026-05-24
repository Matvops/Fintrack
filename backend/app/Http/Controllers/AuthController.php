<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller {

    private AuthService $service;

    function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request) {
        
        $dados = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $response = $this->service->login($dados);

        return $this->sendResponse($response);
    }

    public function register(RegisterRequest $request) {
        
        $dados = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'conformationPassword' => $request->input('conformationPassword'),
        ];

        $response = $this->service->register($dados);

        return $this->sendResponse($response);
    }

    public function logout(LogoutRequest $request) {

        $use_id = $request->input('id');

        $response = $this->service->logout($use_id);

        return $this->sendResponse($response);
    }
}
