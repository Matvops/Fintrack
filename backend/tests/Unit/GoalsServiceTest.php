<?php

namespace Tests\Unit;

use App\Dto\Goal\CreateGoalDTO;
use App\Models\Goal;
use App\Repositories\GoalRepository;
use App\Repositories\UserRepository;
use App\Services\GoalsService;
use Exception;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use TypeError;

#[RunTestsInSeparateProcesses]
class GoalsServiceTest extends MockeryTestCase {

    private GoalsService $service;
    private GoalRepository&MockInterface $goalRepository;
    private UserRepository&MockInterface $userRepository;

    public function setUp(): void
    {
        $this->goalRepository = Mockery::mock(GoalRepository::class);
        $this->userRepository = Mockery::mock(UserRepository::class);
        $this->service = new GoalsService($this->userRepository, $this->goalRepository);
    }

    
    public function test_create_goal_successfully(): void 
    {
        $log = Mockery::mock('alias:App\Logging\LogInvoker');
        $log->shouldReceive('create->withPayload->withResponse->save')->andReturnNull();
        
        $dto = CreateGoalDTO::fromArray([
            'id' => 1,
            'name' => 'VIAGEM',
            'balance' => 'R$ 2.200,00',
            'balanceTarget' => 'R$ 3.500,00',
            'color' => 'ESMERALDA',
        ]);

        $goal = new Goal();
        $goal->gls_use_id = $dto->userId;
        $goal->gls_name = $dto->name;
        $goal->gls_balance = $dto->balance;
        $goal->gls_balance_target = $dto->balanceTarget;
        $goal->gls_color = $dto->color;

        $this->goalRepository->shouldReceive('register')
                            ->once()
                            ->with($dto)
                            ->andReturn($goal);

        $response = $this->service->create($dto);
        $this->assertTrue($response->getStatus());
        $this->assertSame('Meta criada com sucesso', $response->getMessage());
    }

    public function test_register_with_throwable(): void 
    {
        
        $logInvoker = Mockery::mock('alias:App\Logging\LogInvoker');
        $logInvoker->shouldReceive('create->withPayload->save')->andReturnNull();
    
        $dto = CreateGoalDTO::fromArray([
            'id' => 1,
            'name' => 'VIAGEM',
            'balance' => 'R$ 2.200,00',
            'balanceTarget' => 'R$ 3.500,00',
            'color' => 'ESMERALDA',
        ]);

        $this->goalRepository->shouldReceive('register')
                                ->once()
                                ->with($dto)
                                ->andThrow(Exception::class);

        $response = $this->service->create($dto);

        $this->assertFalse($response->getStatus());
        $this->assertSame('Erro ao criar meta', $response->getMessage());
        $this->assertSame(500, $response->getCode());
    }
}