<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Models\Goal;
use App\Repositories\GoalRepository;
use App\Repositories\UserRepository;
use App\Utils\Response;
use Exception;

class GoalsService {

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

            if(!isset($user)) throw new ValidationException('Erro ao criar meta', 404);

            $balance = preg_replace('/[^0-9.]/', '', str_replace(',', '.', str_replace('.', '', $data['balance'])));
            $balanceTarget = preg_replace('/[^0-9.]/', '', str_replace(',', '.', str_replace('.', '', $data['balanceTarget'])));

            $goal = new Goal();
            $goal->gls_use_id = $user->use_id;
            $goal->gls_name = $data['name'];
            $goal->gls_balance = $balance;
            $goal->gls_balance_target = str_replace(',', '.', $balanceTarget);
            $goal->gls_color = strtoupper($data['color']);
            $goal->save();
            
            return Response::getResponse(true, 'Meta criada com sucesso');
        } catch(ValidationException $e) {
            return Response::getResponse(false, $e->getMessage(), code: $e->getCode());
        } catch(Exception $e) {
            return Response::getResponse(false, 'Erro ao criar meta', code: 500);
        }
    }


    public function getGoals(int $id): Response
    {
        try {
            
            $goals = $this->goalRepository->getGoalRepository($id);

            if(count($goals) < 1) throw new NotFoundException("Sem metas");
            
            foreach($goals as $goal) {
                $goal->percentage = $this->getPercentage($goal);
                $goal->missing =  $goal->gls_balance_target - $goal->gls_balance;
            }

            return Response::getResponse(true, 'Meta criada com sucesso', $goals);
        } catch(NotFoundException $e) {
            return Response::getResponse(false, $e->getMessage(), code: $e->getCode());
        } catch(Exception $e) {
            return Response::getResponse(false, 'Metas não localizadas', code: 500);
        }
    }

    private function getPercentage($goal) {
        return floor($goal->gls_balance / $goal->gls_balance_target * 100);
    } 
}