<?php

namespace App\Http\Controllers;

use App\Http\Requests\Goals\CreateRequest;
use App\Services\GoalsService;

class GoalsController extends Controller {

    private GoalsService $service;

    public function __construct(GoalsService $service)
    {
        $this->service = $service;
    }

    public function create(CreateRequest $request) {

        $data = [
            'id' => $request->input('id'),
            'name' => $request->input('name'),
            'balance' => $request->input('balance'),
            'balanceTarget' => $request->input('balanceTarget'),
            'color' => $request->input('color'),
        ];

        $response = $this->service->create($data);

        return $this->sendResponse($response);
    }
}