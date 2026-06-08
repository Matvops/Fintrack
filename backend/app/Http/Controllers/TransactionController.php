<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transactions\CreateTransactionRequest;
use App\Services\TransactionService;
use Illuminate\Http\Request;

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
}
