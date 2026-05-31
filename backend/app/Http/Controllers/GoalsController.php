<?php

namespace App\Http\Controllers;

use App\Http\Requests\Goals\CreateRequest;
use App\Http\Requests\Goals\DeleteRequest;
use App\Http\Requests\Goals\EditRequest;
use App\Http\Requests\Goals\GetGoalsRequest;
use App\Services\GoalsService;

class GoalsController extends Controller
{

    private GoalsService $service;

    public function __construct(GoalsService $service)
    {
        $this->service = $service;
    }

    public function create(CreateRequest $request)
    {

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

    public function getGoals(GetGoalsRequest $request)
    {

        $id = $request->input('id');

        $response = $this->service->getGoals($id);

        return $this->sendResponse($response);
    }

    public function edit(EditRequest $request)
    {

        $dados = [
            'gls_id' => $request->input('gls_id'),
            'gls_name' => $request->input('gls_name'),
            'gls_balance' => $request->input('gls_balance'),
            'gls_balance_target' => $request->input('gls_balance_target'),
            'gls_color' => $request->input('gls_color'),
        ];

        $response = $this->service->edit($dados);

        return $this->sendResponse($response);
    }

    public function delete(DeleteRequest $request)
    {

        $id = $request->input('id');

        $response = $this->service->delete($id);

        return $this->sendResponse($response);
    }
}
