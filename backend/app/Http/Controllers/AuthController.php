<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller {

    private AuthService $service;

    function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(Request $request) {

        error_log(json_encode($request->all()));
        
        return response('123', 200);
    }

    public function register(RegisterRequest $request) {
        
        $dados = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'conformationPassword' => $request->input('conformationPassword'),
        ];

        $response = $this->service->register($dados);

        return response($response, 200);
    }
}
