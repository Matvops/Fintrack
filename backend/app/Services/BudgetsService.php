<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Budget;
use App\Repositories\BudgetRepository;
use App\Utils\Functions;
use App\Utils\Response;
use Exception;

class BudgetsService {

    private BudgetRepository $budgetRepository;

    public function __construct(BudgetRepository $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
    }


    public function create(array $request): Response
    {
        try {
            
            $budget = new Budget();
            $budget->bdt_use_id = $request['id'];
            $budget->bdt_name = $request['name'];
            $budget->bdt_limit = Functions::formatValue($request['limit']);
            $budget->bdt_color = strtoupper($request['color']);
            $budget->bdt_current_expense = 0;
            $budget->save();

            return Response::getResponse(true, 'Orçamento criado com sucesso', code: 201);
        } catch(Exception $e) {
            return Response::getResponse(false, 'Erro ao criar novo orçamento', code: $e->getCode());
        }
    }

    public function get(int $id): Response
    {
        try {
            
            $budgets = $this->budgetRepository->getBudgetsByUseId($id);

            if (count($budgets) < 1) throw new NotFoundException("Sem Orçamentos");

            return Response::getResponse(true, 'Orçamentos encontrados', $budgets);
        } catch(Exception $e) {
            return Response::getResponse(false, 'Erro ao localizar orçamentos', code: $e->getCode());
        }
    }
}