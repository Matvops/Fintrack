<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository {

    public function getBudgetsByUseId(int $useId) 
    {
        return Transaction::with('budget')->where('tra_use_id', $useId)->orderBy('tra_date', 'DESC')->get();
    }
}