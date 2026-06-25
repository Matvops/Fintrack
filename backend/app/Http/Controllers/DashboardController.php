<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dashboard\GetDashboardRequest;
use App\Services\DashboardService;

class DashboardController extends Controller{

    private DashboardService $service;

    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    public function get(GetDashboardRequest $request) {

        $request = [
            'id' => $request->input('id'),
            'date' => $request->input('date')
        ];

        $response = $this->service->getDashboardData($request);

        return $this->sendResponse($response);

    }
}