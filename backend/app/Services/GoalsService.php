<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Logging\ErrorLogBuilder;
use App\Logging\InfoLogBuilder;
use App\Logging\LogInvoker;
use App\Models\Goal;
use App\Repositories\GoalRepository;
use App\Repositories\UserRepository;
use App\Utils\Functions;
use App\Utils\Response;
use Exception;
use Illuminate\Support\Facades\DB;

class GoalsService
{

    private UserRepository $userRepository;
    private GoalRepository $goalRepository;

    public function __construct(UserRepository $userRepository, GoalRepository $goalRepository)
    {
        $this->userRepository = $userRepository;
        $this->goalRepository = $goalRepository;
    }


    public function create(array $data): Response
    {
        try {

            $user = $this->userRepository->getUserById($data['id']);

            if (!isset($user)) throw new ValidationException('Erro ao criar meta', 404);

            $balance = Functions::formatValue($data['balance']);
            $balanceTarget = Functions::formatValue($data['balanceTarget']);

            $goal = new Goal();
            $goal->gls_use_id = $user->use_id;
            $goal->gls_name = $data['name'];
            $goal->gls_balance = $balance;
            $goal->gls_balance_target = str_replace(',', '.', $balanceTarget);
            $goal->gls_color = strtoupper($data['color']);
            $goal->save();

            LogInvoker::create(new InfoLogBuilder)
                        ->withPayload($data)
                        ->withPayload($goal)
                        ->save('GOAL');


            return Response::getResponse(true, 'Meta criada com sucesso');
        } catch (ValidationException $e) {
            LogInvoker::create(new ErrorLogBuilder)
                        ->withPayload($data)
                        ->save('GOAL', $e);
            return Response::getResponse(false, $e->getMessage(), code: $e->getCode());
        } catch (Exception $e) {
            LogInvoker::create(new ErrorLogBuilder)
                        ->withPayload($data)
                        ->save('GOAL', $e);
            return Response::getResponse(false, 'Erro ao criar meta', code: 500);
        }
    }


    public function getGoals(int $id): Response
    {
        try {

            $goals = $this->goalRepository->getGoalsByUseId($id);

            if (count($goals) < 1) throw new NotFoundException("Sem metas");

            foreach ($goals as $goal) {
                $goal->percentage = Functions::getPercentage((float) $goal->gls_balance, (float) $goal->gls_balance_target);
                $goal->missing =  $goal->gls_balance_target - $goal->gls_balance;
            }

            return Response::getResponse(true, 'Metas encontradas', $goals);
        } catch (NotFoundException $e) {
            return Response::getResponse(false, $e->getMessage(), [], code: $e->getCode());
        } catch (Exception $e) {
            return Response::getResponse(false, 'Metas não localizadas', [], code: 500);
        }
    }

    public function edit(array $request): Response
    {
        try {

            DB::beginTransaction();

            $goal = $this->goalRepository->getGoalById($request['gls_id']);

            if(!$goal) throw new NotFoundException("Erro ao localizar meta");

            $goal->gls_name = $request['gls_name'];
            $goal->gls_balance = Functions::formatValue($request['gls_balance']);
            $goal->gls_balance_target = Functions::formatValue($request['gls_balance_target']);
            $goal->gls_color = strtoupper($request['gls_color']);
            $goal->save();

            LogInvoker::update(new InfoLogBuilder)
                        ->withPayload($request)
                        ->withResponse($goal)
                        ->save('GOAL');

            DB::commit();

            return Response::getResponse(true, 'Meta editada com sucesso');
        } catch (NotFoundException $e) {
            DB::rollBack();
            LogInvoker::update(new ErrorLogBuilder)
                        ->withPayload($request)
                        ->save('GOAL', $e);
            return Response::getResponse(false, $e->getMessage(), code: $e->getCode());
        } catch (Exception $e) {
            DB::rollBack();
            LogInvoker::update(new ErrorLogBuilder)
                        ->withPayload($request)
                        ->save('GOAL', $e);
            return Response::getResponse(false, 'Metas não localizadas', code: 500);
        }
    }

    public function delete(int $id): Response
    {
        try {

            DB::beginTransaction();

            $goal = $this->goalRepository->getGoalById($id);
            
            if(!$goal) throw new NotFoundException("Erro ao localizar meta");

            $goal->delete();

            LogInvoker::delete(new InfoLogBuilder)
                        ->withPayload(['id' => $id])
                        ->withResponse($goal)
                        ->save('GOAL');

            DB::commit();
            return Response::getResponse(true, 'Meta excluída com sucesso');
        } catch (NotFoundException $e) {
            DB::rollBack();
            LogInvoker::delete(new ErrorLogBuilder)
                        ->withPayload(['id' => $id])
                        ->save('GOAL', $e);

            return Response::getResponse(false, $e->getMessage(), code: $e->getCode());
        } catch (Exception $e) {
            DB::rollBack();
            LogInvoker::delete(new ErrorLogBuilder)
                        ->withPayload(['id' => $id])
                        ->save('GOAL', $e);
                        
            return Response::getResponse(false, 'Metas não localizadas', code: 500);
        }
    }
}
