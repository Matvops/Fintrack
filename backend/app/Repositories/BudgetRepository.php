<?php

namespace App\Repositories;

use App\Models\Budget;

class BudgetRepository {

    public function getBudgetsByUseId(int $id, string $initialDate, string $finishDate) {
        return Budget::where('bdt_use_id', $id)
                        ->whereBetween('created_at', [$initialDate, $finishDate])
                        ->orderBy('created_at', 'DESC')
                        ->get();
    }

    public function getBudgetById(int $id): ?Budget
    {
        return Budget::where('bdt_id', $id)->first();
    }
}