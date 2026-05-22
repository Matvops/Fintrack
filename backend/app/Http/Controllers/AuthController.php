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
}
