<?php

namespace Tests\Unit;

use App\Dto\Transaction\CreateTransactionDTO;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Services\TransactionService;
use Exception;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Override;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

#[RunTestsInSeparateProcesses]
class TransactionServiceTest extends MockeryTestCase {

    private TransactionService $service;
    private MockInterface&TransactionRepository $repository;

    #[Override]
    public function setUp(): void
    {
        $this->repository = Mockery::mock(TransactionRepository::class);
        $this->service = new TransactionService($this->repository);
    }

    public function test_create_transaction_sucessfully(): void
    {
        $log = Mockery::mock('alias:App\Logging\LogInvoker');
        $log->shouldReceive('create->withPayload->withResponse->save')->andReturnNull();

        $dto = CreateTransactionDTO::fromArray([
            'id' => 1,
            'type' => 'income',
            'description' => 'Teste',
            'value' => 150.00,
            'date' => '2026-06-22'
        ]);

        $transaction = new Transaction();
        $transaction->tra_id = 1;
        $transaction->tra_use_id = $dto->userId;
        $transaction->tra_bdt_id = $dto->categoryId;
        $transaction->tra_description = $dto->description;
        $transaction->tra_value = $dto->value;
        $transaction->tra_date = $dto->date;
        $transaction->tra_type = $dto->type;

        $this->repository->shouldReceive('register')
                        ->once()
                        ->with($dto)
                        ->andReturn($transaction);

        $response = $this->service->create($dto);

        $this->assertTrue($response->getStatus());
        $this->assertSame('Transação cadastrada com sucesso', $response->getMessage());
    }

    public function test_create_transaction_with_error(): void
    {
        $log = Mockery::mock('alias:App\Logging\LogInvoker');
        $log->shouldReceive('create->withPayload->save')->andReturnNull();

        $dto = CreateTransactionDTO::fromArray([
            'id' => 1,
            'type' => 'income',
            'description' => 'Teste',
            'value' => 150.00,
            'date' => '2026-06-22'
        ]);

        $this->repository->shouldReceive('register')
                        ->once()
                        ->with($dto)
                        ->andThrow(Exception::class);

        $response = $this->service->create($dto);

        $this->assertFalse($response->getStatus());
        $this->assertSame('Erro ao cadastrar transação', $response->getMessage());
    }
}