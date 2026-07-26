<?php

namespace Tests\Unit;

use App\Dto\Budget\CreateBudgetDTO;
use App\Dto\Budget\EditBudgetDTO;
use App\Models\Budget;
use App\Repositories\BudgetRepository;
use App\Repositories\TransactionRepository;
use App\Services\BudgetsService;
use Error;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

#[RunTestsInSeparateProcesses]
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

    public function test_edit_budget_successfully(): void 
    {

        $log = Mockery::mock('alias:App\Logging\LogInvoker');
        $log->shouldReceive('update->withPayload->withResponse->save');
        
        $db = Mockery::mock('alias:Illuminate\Support\Facades\DB');
        $db->shouldReceive('beginTransaction')->andReturnNull();
        $db->shouldReceive('commit')->andReturnNull();

        $dto = EditBudgetDTO::fromArray([
            'bdt_id' => 1,
            'bdt_name' => 'Transporte',
            'bdt_limit' => '4.230,23',
            'bdt_color' => 'violeta',
        ]);

        $oldBudget = new Budget();
        $oldBudget->setRawAttributes([
            'bdt_name'  => 'Alimentação',
            'bdt_limit' => 3564.22,
            'bdt_color' => 'ESMERALDA',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $newBudget = new Budget();
        $newBudget->setRawAttributes([
            'bdt_name'  => $dto->name,
            'bdt_limit' => $dto->limit,
            'bdt_color' => $dto->color,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->budgetRepository->shouldReceive('getBudgetById')
                                ->once()
                                ->with($dto->id)
                                ->andReturn($oldBudget);

        $this->budgetRepository->shouldReceive('edit')
                                ->once()
                                ->with($dto, $oldBudget)
                                ->andReturn($newBudget);
            
        $response = $this->service->edit($dto);
        
        $this->assertTrue($response->getStatus());
        $this->assertSame('Orçamento editado com sucesso', $response->getMessage());
    }

    public function test_edit_budget_with_error(): void 
    {

        $log = Mockery::mock('alias:App\Logging\LogInvoker');
        $log->shouldReceive('update->withPayload->save');
        
        $db = Mockery::mock('alias:Illuminate\Support\Facades\DB');
        $db->shouldReceive('beginTransaction')->andReturnNull();
        $db->shouldReceive('rollback')->andReturnNull();

        $dto = EditBudgetDTO::fromArray([
            'bdt_id' => 1,
            'bdt_name' => 'Transporte',
            'bdt_limit' => '4.230,23',
            'bdt_color' => 'violeta',
        ]);

        $oldBudget = new Budget();
        $oldBudget->setRawAttributes([
            'bdt_name'  => 'Alimentação',
            'bdt_limit' => 3564.22,
            'bdt_color' => 'ESMERALDA',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->budgetRepository->shouldReceive('getBudgetById')
                                ->once()
                                ->with($dto->id)
                                ->andReturn($oldBudget);

        $this->budgetRepository->shouldReceive('edit')
                                ->once()
                                ->with($dto, $oldBudget)
                                ->andThrow(Error::class);
            
        $response = $this->service->edit($dto);
        
        $this->assertFalse($response->getStatus());
        $this->assertSame('Orçamento não localizado', $response->getMessage());
        $this->assertSame(500, $response->getCode());
    }

    public function test_delete_successfully(): void 
    {
        $log = Mockery::mock('alias:App\Logging\LogInvoker');
        $log->shouldReceive('delete->withPayload->withResponse->save');
        
        $db = Mockery::mock('alias:Illuminate\Support\Facades\DB');
        $db->shouldReceive('beginTransaction')->andReturnNull();
        $db->shouldReceive('commit')->andReturnNull();

        $budget = Mockery::mock(Budget::class);

        $id = 1;
        $this->budgetRepository->shouldReceive('getBudgetById')
                                ->once()
                                ->with($id)
                                ->andReturn($budget);

        $budget->shouldReceive('transactions')
                ->once()
                ->andReturnNull();

        $budget->shouldReceive('delete')->andReturnTrue();


        $response = $this->service->delete($id);

        $this->assertTrue($response->getStatus());
        $this->assertSame('Orçamento excluído com sucesso', $response->getMessage());
    }

    public function test_delete_with_transactions_linked_budget(): void 
    {
        $log = Mockery::mock('alias:App\Logging\LogInvoker');
        $log->shouldReceive('delete->withPayload->save');
        
        $db = Mockery::mock('alias:Illuminate\Support\Facades\DB');
        $db->shouldReceive('beginTransaction')->andReturnNull();
        $db->shouldReceive('rollback')->andReturnNull();

        $budget = Mockery::mock(Budget::class);

        $id = 1;
        $this->budgetRepository->shouldReceive('getBudgetById')
                                ->once()
                                ->with($id)
                                ->andReturn($budget);

        $budget->shouldReceive('transactions')
                ->once()
                ->andReturn(['TRANSACTION1', 'TRANSACTION2', 'TRANSACTION3']);

        $budget->shouldReceive('delete')->andReturnTrue();


        $response = $this->service->delete($id);

        $this->assertFalse($response->getStatus());
        $this->assertSame('Esta categoria possui transações cadastradas', $response->getMessage());
        $this->assertSame(403, $response->getCode());
    }
    
    public function test_delete_with_error(): void 
    {
        $log = Mockery::mock('alias:App\Logging\LogInvoker');
        $log->shouldReceive('delete->withPayload->save');
        
        $db = Mockery::mock('alias:Illuminate\Support\Facades\DB');
        $db->shouldReceive('beginTransaction')->andReturnNull();
        $db->shouldReceive('rollback')->andReturnNull();

        $budget = Mockery::mock(Budget::class);

        $id = 1;
        $this->budgetRepository->shouldReceive('getBudgetById')
                                ->once()
                                ->with($id)
                                ->andReturn($budget);

        $budget->shouldReceive('transactions')
                ->once()
                ->andReturnNull();

        $budget->shouldReceive('delete')->andThrow(Error::class);

        $response = $this->service->delete($id);

        $this->assertFalse($response->getStatus());
        $this->assertSame('Orçamento não localizado', $response->getMessage());
        $this->assertSame(500, $response->getCode());
    }
}