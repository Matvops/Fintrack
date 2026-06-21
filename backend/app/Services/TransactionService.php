<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
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


    public function create(array $data): Response
    {
        try {

            $transaction = new Transaction();
            $transaction->tra_use_id = $data['id'];
            $transaction->tra_bdt_id = $data['category'];
            $transaction->tra_description = $data['description'];
            $transaction->tra_value = Functions::formatValue($data['value']);
            $transaction->tra_date = Carbon::parse("{$data['date']} 00:00:00")->toDateTimeString();
            $transaction->tra_type = strtoupper($data['type']);
            $transaction->save();

            return Response::getResponse(true, 'Transação cadastrada com sucesso');
        } catch (Exception $e) {
            error_log($e->getMessage());
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
        } catch (Exception $e) {
            return Response::getResponse(false, 'Erro ao localizar transações', code: $e->getCode());
        }
    }
}
