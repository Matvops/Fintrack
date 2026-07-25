<?php

namespace App\Dto\Goal;

use App\Models\Goal;
use App\Utils\Functions;

readonly class GoalDTO {

    public function __construct(
        public int $id,
        public int $userId,
        public string $name,
        public float $balance,
        public float $balanceTarget,
        public string $color,
        public string $created_at,
        public string $updated_at,
        public float $percentage,
        public float $missing,
    )
    {}

    public static function fromGoal(Goal $goal): self
    {
        return new self(
            id: $goal->gls_id,
            userId: $goal->gls_use_id,
            name: $goal->gls_name,
            balance: $goal->gls_balance,
            balanceTarget: $goal->gls_balance_target,
            color: strtoupper($goal->gls_color),
            created_at: $goal->created_at,
            updated_at: $goal->updated_at,
            percentage: Functions::getPercentage((float) $goal->gls_balance, (float) $goal->gls_balance_target),
            missing: floatval($goal->gls_balance_target - $goal->gls_balance),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'name' => $this->name,
            'balance' => $this->balance,
            'balanceTarget' => $this->balanceTarget,
            'color' => $this->color,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'percentage' => $this->percentage,
            'missing' => $this->missing,
        ];
    }
}