<?php 

namespace App\Dto\Budget;

use App\Models\Budget;
use App\Utils\Functions;
use Illuminate\Database\Eloquent\Collection;

readonly class BudgetDTO {

    public function __construct(
        public int $id,
        public string $name,
        public string $limit,
        public string $color,
        public string|null $amountSpent,
        public string|null $remainingValue,
        public float|null $percentage,
        public array|null $transactions,
    )
    {}

    public static function fromBudget(Budget $budget, array $transactions): self
    {
        $amountSpent = strval(array_reduce($transactions, fn ($carry, $item) => $carry + $item['tra_value'], 0));

        return new self(
            id: $budget->bdt_id,
            name: $budget->bdt_name,
            limit: $budget->bdt_limit,
            color: $budget->bdt_color,
            amountSpent: number_format($amountSpent, 2, '.', ''),
            remainingValue: number_format($budget->bdt_limit - $amountSpent, 2, '.', ''),
            percentage: Functions::getPercentage($amountSpent, $budget->bdt_limit),
            transactions: $transactions
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'limit' => $this->limit,
            'color' => $this->color,
            'amountSpent' => $this->amountSpent,
            'remainingValue' => $this->remainingValue,
            'percentage' => $this->percentage,
            'transactions' => $this->transactions
        ];
    }
}