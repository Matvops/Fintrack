<?php

namespace Tests\Unit;

use App\Dto\Transaction\CreateTransactionDTO;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Services\TransactionService;
use App\Utils\Functions;
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

    public function test_get_transactions_by_use_id_successfully(): void 
    {
        $now = round(microtime(true) * 1000);

        $dataInicio = Functions::getInitialDateOfMonth($now);
        $dataFim = Functions::getFinishDateOfMonth($now);
        $return = [1, 2, 3, 4, 5];
        $this->repository->shouldReceive('getTransactionsByUseId')
                        ->once()
                        ->with(1, $dataInicio, $dataFim)
                        ->andReturn($return);

        $response = $this->service->getByUseId(['id' => 1, 'date' => $now]);
        $this->assertTrue($response->getStatus());
        $this->assertSame('Transações encontradas', $response->getMessage());
        $this->assertSame(5, count($response->getData()));
    }

    public function test_get_transactions_by_use_id_without_transactions(): void 
    {
        $now = round(microtime(true) * 1000);

        $dataInicio = Functions::getInitialDateOfMonth($now);
        $dataFim = Functions::getFinishDateOfMonth($now);
        $return = [];
        $this->repository->shouldReceive('getTransactionsByUseId')
                        ->once()
                        ->with(1, $dataInicio, $dataFim)
                        ->andReturn($return);

        $response = $this->service->getByUseId(['id' => 1, 'date' => $now]);
        $this->assertFalse($response->getStatus());
        $this->assertSame('Sem Transações', $response->getMessage());
        $this->assertSame(404, $response->getCode());
    }
}