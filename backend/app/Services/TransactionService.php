<?php

namespace App\Services;

use App\Dto\Transaction\CreateTransactionDTO;
use App\Exceptions\NotFoundException;
use App\Logging\ErrorLogBuilder;
use App\Logging\InfoLogBuilder;
use App\Logging\LogInvoker;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Utils\Functions;
use App\Utils\Response;
use Carbon\Carbon;
use Exception;

class TransactionService
{

    private TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }


    public function create(CreateTransactionDTO $createTransactionDTO): Response
    {
        try {

            $transaction = $this->transactionRepository->register($createTransactionDTO);

            LogInvoker::create(new InfoLogBuilder)
                        ->withPayload($createTransactionDTO)
                        ->withResponse($transaction)
                        ->save('TRANSACTION');

            return Response::getResponse(true, 'Transação cadastrada com sucesso');
        } catch (Exception $e) {
            LogInvoker::create(new ErrorLogBuilder)
                        ->withPayload($createTransactionDTO)
                        ->save('TRANSACTION', $e);

            return Response::getResponse(false, 'Erro ao cadastrar transação');
        }
    }

    public function getByUseId(array $request): Response
    {
        try {

            $initialDate = Functions::getInitialDateOfMonth($request['date']);
            $finishDate = Functions::getFinishDateOfMonth($request['date']);

            $transactions = $this->transactionRepository->getTransactionsByUseId($request['id'], $initialDate, $finishDate);

            if (count($transactions) < 1) throw new NotFoundException("Sem Transações");

            return Response::getResponse(true, 'Transações encontradas', $transactions);
        } catch(NotFoundException $e) {
            return Response::getResponse(false, $e->getMessage(), code: $e->getCode());
        } catch (Exception $e) {
            return Response::getResponse(false, 'Erro ao localizar transações', code: $e->getCode());
        }
    }
}
