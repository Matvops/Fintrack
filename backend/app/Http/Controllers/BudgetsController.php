<?php

namespace App\Http\Controllers;

use App\Http\Requests\Budgets\CreateRequest;
use App\Http\Requests\Budgets\DeleteRequest;
use App\Http\Requests\Budgets\EditRequest;
use App\Http\Requests\Budgets\GetBudgetsRequest;
use App\Services\BudgetsService;

class BudgetsController extends Controller {

    private BudgetsService $service;

    public function __construct(BudgetsService $service)
    {
        $this->service = $service;
    }

    public function create(CreateRequest $request) {
        
        $dados = [
            'id' => $request->input('id'),
            'name' => $request->input('name'),
            'limit' => $request->input('limit'),
            'color' => $request->input('color'),
        ];

        $response = $this->service->create($dados);

        return $this->sendResponse($response);
    }

    public function getBudgets(GetBudgetsRequest $request) {
        
        $id = $request->input('id');

        $response = $this->service->get($id);

        return $this->sendResponse($response);
    }

    public function delete(DeleteRequest $request) {
        
        $id = $request->input('id');

        $response = $this->service->delete($id);

        return $this->sendResponse($response);
    }

    public function edit(EditRequest $request) {
        
        $dados = [
            'bdt_id' => $request->input('bdt_id'),
            'bdt_name' => $request->input('bdt_name'),
            'bdt_color' => $request->input('bdt_color'),
            'bdt_limit' => $request->input('bdt_limit'),
        ];

        $response = $this->service->edit($dados);

        return $this->sendResponse($response);
    }
} 