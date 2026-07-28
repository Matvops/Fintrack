<?php

namespace App\Dto\Transaction;

use App\Utils\Functions;
use Carbon\Carbon;

readonly class CreateTransactionDTO {

    public function __construct(
        public int $userId,
        public ?int $categoryId,
        public string $description,
        public string $type,
        public string $date,
        public string $value,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            userId: $data['id'],
            categoryId: isset($data['category']) ? $data['category'] : null,
            description: $data['description'],
            type: strtoupper($data['type']),
            date: Carbon::parse("{$data['date']} 00:00:00")->toDateTimeString(),
            value: Functions::formatValue($data['value']),
        );
    }

    public function toArray(): array 
    {
        return [
            'userId' => $this->userId,
            'categoryId' => $this->categoryId,
            'description' => $this->description,
            'type' => $this->type,
            'date' => $this->date,
            'value' => $this->value,
        ];
    }
}