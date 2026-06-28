<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\PermissionDeniedException;
use App\Logging\InfoLogBuilder;
use App\Logging\LogInvoker;
use App\Models\Budget;
use App\Repositories\BudgetRepository;
use App\Repositories\TransactionRepository;
use App\Utils\Functions;
use App\Utils\Response;
use Exception;
use Illuminate\Support\Facades\DB;

class BudgetsService {

    private BudgetRepository $budgetRepository;
    private TransactionRepository $transactionRepository;

    public function __construct(BudgetRepository $budgetRepository, TransactionRepository $transactionRepository)
    {
        $this->budgetRepository = $budgetRepository;
        $this->transactionRepository = $transactionRepository;
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

            LogInvoker::create(new InfoLogBuilder)
                        ->withPayload($request)
                        ->withResponse($budget)
                        ->save('BUDGET');

            return Response::getResponse(true, 'Orçamento criado com sucesso', code: 201);
        } catch(Exception $e) {
            return Response::getResponse(false, 'Erro ao criar novo orçamento', code: $e->getCode());
        }
    }

    public function get(array $request): Response
    {
        try {
            
            $initialDate = Functions::getInitialDateOfMonth($request['date']);
            $finishDate = Functions::getFinishDateOfMonth($request['date']);
        
            $budgets = $this->budgetRepository->getBudgetsByUseId($request['id'], $initialDate, $finishDate);

            if (count($budgets) < 1) throw new NotFoundException("Sem Orçamentos");

            foreach($budgets as $budget) {
                $transactions = $this->transactionRepository->getTransactionsByBudgetId($budget->bdt_id, $initialDate, $finishDate)->toArray();
                $budget->bdt_transactions = $transactions;
                $budget->bdt_amount_spent = strval(array_reduce($transactions, fn ($carry, $item) => $carry + $item['tra_value'], 0));
                $budget->bdt_remaining_value = strval($budget->bdt_limit - $budget->bdt_amount_spent);
                $budget->bdt_percentage = Functions::getPercentage($budget->bdt_amount_spent, $budget->bdt_limit);
            }

            return Response::getResponse(true, 'Orçamentos encontrados', $budgets);
        } catch(Exception $e) {
            return Response::getResponse(false, 'Erro ao localizar orçamentos', code: $e->getCode());
        }
    }

    public function delete(int $id): Response
    {
        try {

            DB::beginTransaction();

            $budget = $this->budgetRepository->getBudgetById($id);

            $transactions = $budget->transactions();

            if($transactions) throw new PermissionDeniedException('Esta categoria possui transações cadastradas');

            $budget->delete();

            LogInvoker::delete(new InfoLogBuilder)
                        ->withPayload(['id' => $id])
                        ->withResponse($budget)
                        ->save('BUDGET');

            DB::commit();
            return Response::getResponse(true, 'Orçamento excluído com sucesso');
        } catch (NotFoundException|PermissionDeniedException $e) {
            DB::rollBack();
            return Response::getResponse(false, $e->getMessage(), code: $e->getCode());
        } catch (Exception $e) {
            DB::rollBack();
            return Response::getResponse(false, 'Orçamento não localizado', code: 500);
        }
    }

    public function edit(array $data): Response
    {
        try {

            DB::beginTransaction();

            $budget = $this->budgetRepository->getBudgetById($data['bdt_id']);
            $budget->bdt_name = $data['bdt_name'];
            $budget->bdt_limit = Functions::formatValue($data['bdt_limit']);
            $budget->bdt_color = strtoupper($data['bdt_color']);
            $budget->save();

            LogInvoker::update(new InfoLogBuilder)
                        ->withPayload($data)
                        ->withResponse($budget)
                        ->save('BUDGET');

            DB::commit();
            return Response::getResponse(true, 'Orçamento editado com sucesso');
        } catch (Exception $e) {
            DB::rollBack();
            return Response::getResponse(false, 'Orçamento não localizado', code: 500);
        }
    }
}