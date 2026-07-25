<?php

namespace App\Dto\Goal;

use App\Utils\Functions;

readonly class EditGoalDTO {

    public function __construct(
        public int $id,
        public string $name,
        public string $balance,
        public string $balanceTarget,
        public string $color,
    )
    {}

    public static function fromArray(array $array): self
    {
        return new self(
            id: $array['id'],
            name: $array['name'],
            balance: Functions::formatValue($array['balance']),
            balanceTarget: Functions::formatValue($array['balanceTarget']),
            color: strtoupper($array['color']),
        );
    }

    public function toArray(): array 
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'balance' => $this->balance,
            'balanceTarget' => $this->balanceTarget,
            'color' => $this->color,
        ];
    }
}