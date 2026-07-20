<?php

namespace App\Http\Controllers;

use App\Dto\Auth\LoginDTO;
use App\Dto\Auth\RegisterDTO;
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
        
        $loginDTO = LoginDTO::fromArray($request->validated());

        $response = $this->service->login($loginDTO);

        return $this->sendResponse($response);
    }

    public function register(RegisterRequest $request) {
        
        $registerDTO = RegisterDTO::fromArray($request->validated()); 

        $response = $this->service->register($registerDTO);

        return $this->sendResponse($response);
    }

    public function logout(LogoutRequest $request) {

        $use_id = $request->input('id');

        $response = $this->service->logout($use_id);

        return $this->sendResponse($response);
    }
}
