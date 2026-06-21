<?php

namespace App\Repositories;

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
                            ->get();
    } 
}