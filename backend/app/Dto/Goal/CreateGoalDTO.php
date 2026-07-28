<?php

namespace App\Dto\Goal;

use App\Utils\Functions;

readonly class CreateGoalDTO {
    
    public function __construct(
        public int $userId,
        public string $name,
        public string $balance,
        public string $balanceTarget,
        public string $color
    )
    {}

    public static function fromArray(array $data): self
    {
        return new self(
            userId: $data['id'],
            name: $data['name'],
            balance: Functions::formatValue($data['balance']),
            balanceTarget: str_replace(',', '.', Functions::formatValue($data['balanceTarget'])),
            color: strtoupper($data['color']),
        );
    }

    public function toArray(): array
    {
        return [
            'userId' => $this->userId,
            'name' => $this->name,
            'balance' => $this->balance,
            'balanceTarget' => $this->balanceTarget,
            'color' => $this->color
        ];
    }
}