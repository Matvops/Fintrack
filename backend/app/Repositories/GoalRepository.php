<?php

namespace App\Repositories;

use App\Dto\Goal\CreateGoalDTO;
use App\Dto\Goal\EditGoalDTO;
use App\Models\Goal;

class GoalRepository {

    public function getGoalsByUseId(int $id) {
        return Goal::where('gls_use_id', $id)->orderBy('created_at', 'DESC')->get();
    }


    public function getGoalById(int $id): ?Goal
    {
        return Goal::where('gls_id', $id)->first();
    }

    public function register(CreateGoalDTO $dto): Goal
    {
        $goal = new Goal();
        $goal->gls_use_id = $dto->userId;
        $goal->gls_name = $dto->name;
        $goal->gls_balance = $dto->balance;
        $goal->gls_balance_target = $dto->balanceTarget;
        $goal->gls_color = $dto->color;
        $goal->save();

        return $goal;
    }

    public function edit(Goal $goal, EditGoalDTO $dto): Goal
    {
        $goal->gls_name = $dto->name;
        $goal->gls_balance = $dto->balance;
        $goal->gls_balance_target = $dto->balanceTarget;
        $goal->gls_color = $dto->color;
        $goal->save();

        return $goal;
    }
}