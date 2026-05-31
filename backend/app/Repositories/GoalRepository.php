<?php

namespace App\Repositories;

use App\Models\Goal;

class GoalRepository {

    public function getGoalsByUseId(int $id) {
        return Goal::where('gls_use_id', $id)->orderBy('created_at', 'DESC')->get();
    }


    public function getGoalById(int $id): ?Goal
    {
        return Goal::where('gls_id', $id)->first();
    }
}