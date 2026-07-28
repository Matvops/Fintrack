<?php

namespace App\Repositories;

use App\Dto\Budget\CreateBudgetDTO;
use App\Dto\Budget\EditBudgetDTO;
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

    public function register(CreateBudgetDTO $dto): Budget
    {
        $budget = new Budget();
        $budget->bdt_use_id = $dto->id;
        $budget->bdt_name = $dto->name;
        $budget->bdt_limit = $dto->limit;
        $budget->bdt_color = $dto->color;
        $budget->bdt_current_expense = 0;
        $budget->save();

        return $budget;
    }
    
    public function edit(EditBudgetDTO $dto, Budget $budget): Budget
    {
        $budget->bdt_name = $dto->name;
        $budget->bdt_limit = $dto->limit;
        $budget->bdt_color = $dto->color;
        $budget->save();

        return $budget;
    }
}