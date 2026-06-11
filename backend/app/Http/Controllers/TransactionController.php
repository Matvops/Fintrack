<?php

namespace App\Http\Controllers;

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

        $data = [
            'id' => $request->input('id'),
            'category' => $request->input('category'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'value' => $request->input('value'),
            'date' => $request->input('date'),
        ];

        $response = $this->service->create($data);

        return $this->sendResponse($response);
    }

    public function getTransactions(GetTransactionsRequest $request) {

        $id = $request->input('id');

        $response = $this->service->getByUseId($id);

        return $this->sendResponse($response);
    }
}
