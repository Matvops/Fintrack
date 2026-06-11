<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository {

    public function getTransactionsByUseId(int $useId) 
    {
        return Transaction::with('budget')->where('tra_use_id', $useId)->orderBy('tra_date', 'DESC')->get();
    }

    public function getTransactionsByBudgetId(int $budgetId) {
        return Transaction::where('tra_bdt_id', $budgetId)->get();
    } 
}