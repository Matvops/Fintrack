<?php

namespace App\Repositories;

use App\Dto\Transaction\CreateTransactionDTO;
use App\Models\Transaction;

class TransactionRepository {

    public function getTransactionsByUseId(int $useId, string $initialDate, string $finishDate) 
    {
        return Transaction::with('budget')
                            ->where('tra_use_id', $useId)
                            ->whereBetween('tra_date', [$initialDate, $finishDate])
                            ->orderBy('tra_date', 'DESC')
                            ->get();
    }

    public function getTransactionsByBudgetId(int $budgetId, string $initialDate, string $finishDate) {
        return Transaction::where('tra_bdt_id', $budgetId)
                            ->whereBetween('tra_date', [$initialDate, $finishDate])
                            ->get()
                            ->toArray();
    } 

    public function register(CreateTransactionDTO $dto): Transaction
    {
        $transaction = new Transaction();
        $transaction->tra_use_id = $dto->userId;
        $transaction->tra_bdt_id = $dto->categoryId;
        $transaction->tra_description = $dto->description;
        $transaction->tra_value = $dto->value;
        $transaction->tra_date = $dto->date;
        $transaction->tra_type = $dto->type;
        $transaction->save();

        return $transaction;
    }
}