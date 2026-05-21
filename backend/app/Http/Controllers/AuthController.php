<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller {


    public function login(Request $request) {

        error_log(json_encode($request->all()));
        
        return response('123', 200);
    }
}
