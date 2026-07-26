<?php

namespace Tests\Unit;

use App\Repositories\BudgetRepository;
use App\Repositories\TransactionRepository;
use App\Services\BudgetsService;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;

class BudgetsServiceTest extends MockeryTestCase {

    private BudgetsService $service;
    private MockInterface&BudgetRepository $budgetRepository;
    private MockInterface&TransactionRepository $transactionRepository;

    public function setUp(): void
    {
        $this->budgetRepository = Mockery::mock(BudgetRepository::class);
        $this->transactionRepository = Mockery::mock(TransactionRepository::class);
        $this->service = new BudgetsService($this->budgetRepository, $this->transactionRepository);
    }

    
}