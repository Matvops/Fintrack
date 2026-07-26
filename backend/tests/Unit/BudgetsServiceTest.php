<?php

namespace Tests\Unit;

use App\Dto\Budget\CreateBudgetDTO;
use App\Models\Budget;
use App\Repositories\BudgetRepository;
use App\Repositories\TransactionRepository;
use App\Services\BudgetsService;
use Error;
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

    public function test_create_budget_successfully(): void 
    {
        $log = Mockery::mock('alias:App\Logging\LogInvoker');
        $log->shouldReceive('create->withPayload->withResponse->save');

        $dto = CreateBudgetDTO::fromArray([
            'id' => 1,
            'name' => 'Transporte',
            'limit' => 'R$ 3.450,00',
            'color' => 'azul',
        ]);

        $budget = new Budget();
        $budget->bdt_id = 1;
        $budget->bdt_use_id = 1;
        $budget->bdt_name = 'Transporte';
        $budget->bdt_limit = 3450.00;
        $budget->bdt_color = 'ESMERALDA';

        $this->budgetRepository->shouldReceive('register')
                                ->once()
                                ->with($dto)
                                ->andReturn($budget);

        $response = $this->service->create($dto);

        $this->assertTrue($response->getStatus());
        $this->assertSame('Orçamento criado com sucesso', $response->getMessage());
        $this->assertSame(201, $response->getCode());
    }

    public function test_create_budget_with_error(): void 
    {
        $log = Mockery::mock('alias:App\Logging\LogInvoker');
        $log->shouldReceive('create->withPayload->save');

        $dto = CreateBudgetDTO::fromArray([
            'id' => 1,
            'name' => 'Transporte',
            'limit' => 'R$ 3.450,00',
            'color' => 'azul',
        ]);

        $this->budgetRepository->shouldReceive('register')
                                ->once()
                                ->with($dto)
                                ->andThrow(Error::class);

        $response = $this->service->create($dto);

        $this->assertFalse($response->getStatus());
        $this->assertSame('Erro ao criar novo orçamento', $response->getMessage());
    }
}