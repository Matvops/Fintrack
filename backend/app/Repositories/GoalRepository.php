<?php

namespace App\Repositories;

use App\Models\Goal;

class GoalRepository {

    public function getGoalRepository(int $id) {
        return Goal::where('gls_use_id', $id)->orderBy('created_at', 'DESC')->get();
    }
}