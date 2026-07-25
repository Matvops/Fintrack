<?php

namespace Tests\Unit;

use App\Dto\Goal\CreateGoalDTO;
use App\Dto\Goal\EditGoalDTO;
use App\Models\Goal;
use App\Repositories\GoalRepository;
use App\Repositories\UserRepository;
use App\Services\GoalsService;
use Exception;
use LogicException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use TypeError;

#[RunTestsInSeparateProcesses]
class GoalsServiceTest extends MockeryTestCase {

    private GoalsService $service;
    private GoalRepository&MockInterface $goalRepository;

    public function setUp(): void
    {
        $this->goalRepository = Mockery::mock(GoalRepository::class);
        $this->service = new GoalsService($this->goalRepository);
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
            'color' => 'esmeralda',
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

    public function test_edit_goal_successfully(): void 
    {
        $log = Mockery::mock('alias:App\Logging\LogInvoker');
        $log->shouldReceive('update->withPayload->withResponse->save')->andReturnNull();

        $db = Mockery::mock('alias:Illuminate\Support\Facades\DB');
        $db->shouldReceive('beginTransaction')->andReturnNull();
        $db->shouldReceive('commit')->andReturnNull();

        $oldGoal = new Goal();
        $oldGoal->gls_id = 1;
        $oldGoal->gls_name = 'Processador';
        $oldGoal->gls_balance = 'R$ 993,20';
        $oldGoal->gls_balance_target = 'R$ 2.400,22';
        $oldGoal->gls_color = 'azul';

        $dto = EditGoalDTO::fromArray([
            'gls_id' => 1,
            'gls_name' => 'Placa de Vídeo',
            'gls_balance' => 'R$ 1.200,21',
            'gls_balance_target' => 'R$ 4.230,44',
            'gls_color' => 'violeta',
        ]);

        $newGoal = new Goal();
        $newGoal->gls_id = 1;
        $newGoal->gls_name = $dto->name;
        $newGoal->gls_balance = $dto->balance;
        $newGoal->gls_balance_target = $dto->balanceTarget;
        $newGoal->gls_color = $dto->color;

        $this->goalRepository->shouldReceive('getGoalById')
                                ->once()
                                ->with(1)                                       
                                ->andReturn($oldGoal);

        $this->goalRepository->shouldReceive('edit')
                                ->once()
                                ->with($oldGoal, $dto)
                                ->andReturn($newGoal);
        
        $response = $this->service->edit($dto);

        $this->assertTrue($response->getStatus());
        $this->assertSame('Meta editada com sucesso', $response->getMessage());
    }
    
    public function test_edit_goal_with_error(): void 
    {
        $log = Mockery::mock('alias:App\Logging\LogInvoker');
        $log->shouldReceive('update->withPayload->save')->andReturnNull();

        $db = Mockery::mock('alias:Illuminate\Support\Facades\DB');
        $db->shouldReceive('beginTransaction')->andReturnNull();
        $db->shouldReceive('rollback')->andReturnNull();

        $oldGoal = new Goal();
        $oldGoal->gls_id = 1;
        $oldGoal->gls_name = 'Processador';
        $oldGoal->gls_balance = 'R$ 993,20';
        $oldGoal->gls_balance_target = 'R$ 2.400,22';
        $oldGoal->gls_color = 'azul';

        $dto = EditGoalDTO::fromArray([
            'gls_id' => 1,
            'gls_name' => 'Placa de Vídeo',
            'gls_balance' => 'R$ 1.200,21',
            'gls_balance_target' => 'R$ 4.230,44',
            'gls_color' => 'violeta',
        ]);

        $this->goalRepository->shouldReceive('getGoalById')
                                ->once()
                                ->with(1)                                       
                                ->andReturn($oldGoal);

        $this->goalRepository->shouldReceive('edit')
                                ->once()
                                ->with($oldGoal, $dto)
                                ->andThrow(TypeError::class);
        
        $response = $this->service->edit($dto);

        $this->assertFalse($response->getStatus());
        $this->assertSame('Metas não localizadas', $response->getMessage());
        $this->assertSame(500, $response->getCode());
    }

    public function test_delete_goal_successfully(): void 
    {
        $log = Mockery::mock('alias:App\Logging\LogInvoker');
        $log->shouldReceive('delete->withPayload->save')->andReturnNull();

        $db = Mockery::mock('alias:Illuminate\Support\Facades\DB');
        $db->shouldReceive('beginTransaction')->andReturnNull();
        $db->shouldReceive('commit')->andReturnNull();

        $id = 1;
        $this->goalRepository->shouldReceive('delete')
                            ->once()
                            ->with($id)
                            ->andReturnNull();

        $response = $this->service->delete($id);
        
        $this->assertTrue($response->getStatus());
        $this->assertSame('Meta excluída com sucesso', $response->getMessage());
    }

    public function test_delete_goal_with_error(): void 
    {
        $log = Mockery::mock('alias:App\Logging\LogInvoker');
        $log->shouldReceive('delete->withPayload->save')->andReturnNull();

        $db = Mockery::mock('alias:Illuminate\Support\Facades\DB');
        $db->shouldReceive('beginTransaction')->andReturnNull();
        $db->shouldReceive('rollback')->andReturnNull();

        $id = 1;
        $this->goalRepository->shouldReceive('delete')
                            ->once()
                            ->with($id)
                            ->andThrow(LogicException::class);

        $response = $this->service->delete($id);
        
        $this->assertFalse($response->getStatus());
        $this->assertSame('Erro ao excluir a meta', $response->getMessage());
        $this->assertSame(500, $response->getCode());
    }
}