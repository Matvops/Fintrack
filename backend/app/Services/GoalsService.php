<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
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

            return Response::getResponse(true, 'Meta criada com sucesso');
        } catch (ValidationException $e) {
            return Response::getResponse(false, $e->getMessage(), code: $e->getCode());
        } catch (Exception $e) {
            return Response::getResponse(false, 'Erro ao criar meta', code: 500);
        }
    }


    public function getGoals(int $id): Response
    {
        try {

            $goals = $this->goalRepository->getGoalsByUseId($id);

            if (count($goals) < 1) throw new NotFoundException("Sem metas");

            foreach ($goals as $goal) {
                $goal->percentage = $this->getPercentage($goal);
                $goal->missing =  $goal->gls_balance_target - $goal->gls_balance;
            }

            return Response::getResponse(true, 'Metas encontradas', $goals);
        } catch (NotFoundException $e) {
            return Response::getResponse(false, $e->getMessage(), code: $e->getCode());
        } catch (Exception $e) {
            return Response::getResponse(false, 'Metas não localizadas', code: 500);
        }
    }

    private function getPercentage($goal)
    {
        return floor($goal->gls_balance / $goal->gls_balance_target * 100);
    }

    public function edit(array $request): Response
    {
        try {

            DB::beginTransaction();

            $goal = $this->goalRepository->getGoalById($request['gls_id']);

            $goal->gls_name = $request['gls_name'];
            $goal->gls_balance = Functions::formatValue($request['gls_balance']);
            $goal->gls_balance_target = Functions::formatValue($request['gls_balance_target']);
            $goal->gls_color = strtoupper($request['gls_color']);
            $goal->save();

            DB::commit();

            return Response::getResponse(true, 'Meta editada com sucesso');
        } catch (NotFoundException $e) {
            DB::rollBack();
            return Response::getResponse(false, $e->getMessage(), code: $e->getCode());
        } catch (Exception $e) {
            DB::rollBack();
            return Response::getResponse(false, 'Metas não localizadas', code: 500);
        }
    }

    public function delete(int $id): Response
    {
        try {

            DB::beginTransaction();

            $goal = $this->goalRepository->getGoalById($id);
            $goal->delete();

            DB::commit();
            return Response::getResponse(true, 'Meta excluída com sucesso');
        } catch (NotFoundException $e) {
            DB::rollBack();
            return Response::getResponse(false, $e->getMessage(), code: $e->getCode());
        } catch (Exception $e) {
            DB::rollBack();
            return Response::getResponse(false, 'Metas não localizadas', code: 500);
        }
    }
}
