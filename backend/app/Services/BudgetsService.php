<?php

namespace App\Services;

use App\Dto\Budget\BudgetDTO;
use App\Dto\Budget\CreateBudgetDTO;
use App\Dto\Budget\EditBudgetDTO;
use App\Exceptions\NotFoundException;
use App\Exceptions\PermissionDeniedException;
use App\Logging\ErrorLogBuilder;
use App\Logging\InfoLogBuilder;
use App\Logging\LogInvoker;
use App\Repositories\BudgetRepository;
use App\Repositories\TransactionRepository;
use App\Utils\Functions;
use App\Utils\Response;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class BudgetsService {

    private BudgetRepository $budgetRepository;
    private TransactionRepository $transactionRepository;

    public function __construct(BudgetRepository $budgetRepository, TransactionRepository $transactionRepository)
    {
        $this->budgetRepository = $budgetRepository;
        $this->transactionRepository = $transactionRepository;
    }


    public function create(CreateBudgetDTO $dto): Response
    {
        try {
            
           $budget = $this->budgetRepository->register($dto);

            LogInvoker::create(new InfoLogBuilder)
                        ->withPayload($dto->toArray())
                        ->withResponse($budget)
                        ->save('BUDGET');

            return Response::getResponse(true, 'Orçamento criado com sucesso', code: 201);
        } catch(Throwable $e) {
            LogInvoker::create(new ErrorLogBuilder)
                        ->withPayload($dto->toArray())
                        ->save('BUDGET', $e);
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

            $dtos = [];
            foreach($budgets as $budget) {
                $transactions = $this->transactionRepository->getTransactionsByBudgetId($budget->bdt_id, $initialDate, $finishDate);
                $dtos[] = BudgetDTO::fromBudget($budget, $transactions);
            }

            return Response::getResponse(true, 'Orçamentos encontrados', $dtos);
        } catch(NotFoundException $e) {
            return Response::getResponse(false, $e->getMessage(), code: $e->getCode());
        } catch(Throwable $e) {
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
        } catch (PermissionDeniedException $e) {
            DB::rollBack();

            LogInvoker::delete(new ErrorLogBuilder)
                        ->withPayload(['id' => $id])
                        ->save('BUDGET', $e);

            return Response::getResponse(false, $e->getMessage(), code: $e->getCode());
        } catch (Throwable $e) {
            DB::rollBack();
            
            LogInvoker::delete(new ErrorLogBuilder)
                        ->withPayload(['id' => $id])
                        ->save('BUDGET', $e);

            return Response::getResponse(false, 'Orçamento não localizado', code: 500);
        }
    }

    public function edit(EditBudgetDTO $dto): Response
    {
        try {

            DB::beginTransaction();

            $budget = $this->budgetRepository->getBudgetById($dto->id);
            $this->budgetRepository->edit($dto, $budget);

            LogInvoker::update(new InfoLogBuilder)
                        ->withPayload($dto->toArray())
                        ->withResponse($budget)
                        ->save('BUDGET');

            DB::commit();
            return Response::getResponse(true, 'Orçamento editado com sucesso');
        } catch (Throwable $e) {
            DB::rollBack();

            LogInvoker::update(new ErrorLogBuilder)
                        ->withPayload($dto->toArray())
                        ->save('BUDGET', $e);

            return Response::getResponse(false, 'Orçamento não localizado', code: 500);
        }
    }
}