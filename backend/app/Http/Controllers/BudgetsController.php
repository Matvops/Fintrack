<?php

namespace App\Http\Controllers;

use App\Dto\Budget\CreateBudgetDTO;
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
        
        $dto = CreateBudgetDTO::fromArray($request->validated());

        $response = $this->service->create($dto);

        return $this->sendResponse($response);
    }

    public function getBudgets(GetBudgetsRequest $request) {
        
        $request = [
            'id' => $request->input('id'),
            'date' => $request->input('date')
        ];

        $response = $this->service->get($request);

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