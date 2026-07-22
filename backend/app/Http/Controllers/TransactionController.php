<?php

namespace App\Http\Controllers;

use App\Dto\Transaction\CreateTransactionDTO;
use App\Http\Requests\Transactions\CreateTransactionRequest;
use App\Http\Requests\Transactions\GetTransactionsRequest;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    private TransactionService $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function create(CreateTransactionRequest $request) {

        $createTransactionDTO = CreateTransactionDTO::fromArray($request->validated());

        $response = $this->service->create($createTransactionDTO);

        return $this->sendResponse($response);
    }

    public function getTransactions(GetTransactionsRequest $request) {

        $request = [
            'id' => $request->input('id'),
            'date' => $request->input('date')
        ];

        $response = $this->service->getByUseId($request);

        return $this->sendResponse($response);
    }
}
