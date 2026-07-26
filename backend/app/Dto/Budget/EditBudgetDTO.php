<?php

namespace App\Dto\Budget;

use App\Utils\Functions;

readonly class EditBudgetDTO {

    public function __construct(
        public int $id,
        public string $name,
        public string $limit,
        public string $color,
    )
    {}

    public static function fromArray(array $array): self 
    {
        return new self(
            id: $array['bdt_id'], 
            name: $array['bdt_name'], 
            limit: Functions::formatValue($array['bdt_limit']), 
            color: strtoupper($array['bdt_color']), 
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'limit' => $this->limit,
            'color' => $this->color,
        ];
    }
}