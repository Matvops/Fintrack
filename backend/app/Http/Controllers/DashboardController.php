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

        $id = $request->input('id');

        $response = $this->service->getDashboardData($id);

        return $this->sendResponse($response);

    }
}