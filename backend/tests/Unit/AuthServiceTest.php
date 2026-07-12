<?php 

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use RuntimeException;
use Tests\TestCase;

#[RunTestsInSeparateProcesses]
class AuthServiceTest extends TestCase {

    use MockeryPHPUnitIntegration;

    private AuthService $authService;
    private LegacyMockInterface&MockInterface&UserRepository $userRepository;

    public function setUp(): void
    {
        $this->userRepository = Mockery::mock(UserRepository::class);
        $this->authService = new AuthService($this->userRepository);
    }

    public function test_logout_successfully(): void 
    {
        $this->userRepository->shouldReceive('getUserById')
                            ->once()
                            ->with(4)
                            ->andReturn(new User());
        
        $auth = Mockery::mock('alias:Illuminate\Support\Facades\Auth');
        $auth->shouldReceive('logout')->once();


        $response = $this->authService->logout(4);

        $this->assertTrue($response->getStatus());
        $this->assertSame('Logout realizado com sucesso', $response->getMessage());
    }

    public function test_logout_with_not_found_user(): void 
    {
        $this->userRepository->shouldReceive('getUserById')
                            ->once()
                            ->with(4)
                            ->andReturnNull();

        $logInvoker = Mockery::mock('alias:App\Logging\LogInvoker');
        $logInvoker->shouldReceive('logout->withPayload->save')->andReturnNull();


        $response = $this->authService->logout(4);

        $this->assertFalse($response->getStatus());
        $this->assertSame('Erro ao realizar Logout', $response->getMessage());
    }

    public function test_logout_with_exception(): void 
    {
        $this->userRepository->shouldReceive('getUserById')
                            ->once()
                            ->with(4)
                            ->andReturn(new User());

        $logInvoker = Mockery::mock('alias:App\Logging\LogInvoker');
        $logInvoker->shouldReceive('logout->withPayload->save')->andReturnNull();

        $auth = Mockery::mock('alias:Illuminate\Support\Facades\Auth');
        $auth->shouldReceive('logout')->andThrow(RuntimeException::class);

        $response = $this->authService->logout(4);

        $this->assertFalse($response->getStatus());
        $this->assertSame('Erro ao realizar Logout', $response->getMessage());
    }
}