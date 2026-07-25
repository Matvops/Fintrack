<?php

namespace Tests\Unit;

use App\Dto\Goal\CreateGoalDTO;
use App\Dto\Goal\EditGoalDTO;
use App\Exceptions\NotFoundException;
use App\Models\Goal;
use App\Repositories\GoalRepository;
use App\Services\GoalsService;
use App\Utils\Functions;
use Error;
use Exception;
use LogicException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;

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
        $oldGoal->gls_balance = 993.20;
        $oldGoal->gls_balance_target = 2400.22;
        $oldGoal->gls_color = 'azul';

        $dto = EditGoalDTO::fromArray([
            'gls_id' => 1,
            'gls_name' => 'Placa de Vídeo',
            'gls_balance' => 1200.21,
            'gls_balance_target' => 4230.44,
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
        $oldGoal->gls_balance = 933.20;
        $oldGoal->gls_balance_target = 2400.22;
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
                                ->andThrow(Error::class);
        
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

    public function test_get_goals_successfully(): void 
    {
        
        $goals = [];

        
        $id = 1;
        for ($i = 1; $i <= 10; $i++) { 
            $goal = new Goal();
            $goal->setRawAttributes([
                'gls_id' => $i,
                'gls_use_id' => $id,
                'gls_name' => "GOAL $i",
                'gls_balance' => 200 * $i,
                'gls_balance_target' => 300 * $i,
                'gls_color' => 'VIOLETA',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            array_push($goals, $goal);
        }


        $this->goalRepository->shouldReceive('getGoalsByUseId')
                                ->once()
                                ->with($id)
                                ->andReturn($goals);

        $response = $this->service->getGoals($id);
        
        $this->assertTrue($response->getStatus());
        $this->assertSame('Metas encontradas', $response->getMessage());
        $this->assertSame(10, count($response->getData()));
    }

    public function test_get_goals_if_missing_and_percentage_attributes_on_dto_is_correctly(): void
    {
        $goals = [];
        
        $id = 1;
        for ($i = 1; $i <= 5; $i++) { 
            $goal = new Goal();
            $goal->setRawAttributes([
                'gls_id' => $i,
                'gls_use_id' => $id,
                'gls_name' => "GOAL $i",
                'gls_balance' => 200 * $i,
                'gls_balance_target' => 300 * $i,
                'gls_color' => 'VIOLETA',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            array_push($goals, $goal);
        }

        $this->goalRepository->shouldReceive('getGoalsByUseId')
                                ->once()
                                ->with($id)
                                ->andReturn($goals);

        $response = $this->service->getGoals($id);
        $dtos = $response->getData();
        for ($i = 0; $i < count($goals); $i++) { 
            $missing = floatval($goals[$i]->gls_balance_target - $goals[$i]->gls_balance);
            $this->assertSame($missing, $dtos[$i]->missing);
            
            $percentage =  Functions::getPercentage((float) $goals[$i]->gls_balance, (float) $goals[$i]->gls_balance_target);
            $this->assertSame($percentage, $dtos[$i]->percentage);
        }
    }

    public function test_get_goals_without_goals(): void 
    {
        $id = 1;

        $this->goalRepository->shouldReceive('getGoalsByUseId')
                                ->once()
                                ->with($id)
                                ->andReturn([]);

        $response = $this->service->getGoals($id);
        
        $this->assertFalse($response->getStatus());
        $this->assertSame('Sem metas', $response->getMessage());
        $this->assertSame((new NotFoundException())->getCode(), $response->getCode());
    }

    public function test_get_goals_with_error(): void 
    {
        $goals = [];

        
        $id = 1;
        for ($i = 1; $i <= 1; $i++) { 
            $goal = new Goal();
            $goal->setRawAttributes([
                'gls_id' => $i,
                'gls_use_id' => $id,
                'gls_name' => "GOAL $i",
                'gls_balance' => 200 * $i,
                'gls_balance_target' => 300 * $i,
                'gls_color' => 'VIOLETA',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            array_push($goals, $goal);
        }

        $this->goalRepository->shouldReceive('getGoalsByUseId')
                                ->once()
                                ->with($id)
                                ->andReturn($goals);

        $dto = Mockery::mock('alias:App\Dto\Goal\GoalDTO');
        $dto->shouldReceive('fromGoal')->andThrow(Error::class);

        $response = $this->service->getGoals($id);
        
        $this->assertFalse($response->getStatus());
        $this->assertSame('Metas não localizadas', $response->getMessage());
        $this->assertSame(500, $response->getCode());
    }
}