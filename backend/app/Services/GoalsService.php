<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\Goal;
use App\Repositories\UserRepository;
use App\Utils\Response;
use Exception;

class GoalsService {

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function create(array $data): Response
    {
        try {
            
            $user = $this->userRepository->getUserById($data['id']);

            if(!isset($user)) throw new ValidationException('Erro ao criar meta', 404);

            $balance = preg_replace('/[^0-9.]/', '', str_replace(',', '.', $data['balance']));
            $balanceTarget = preg_replace('/[^0-9.]/', '', str_replace(',', '.', $data['balanceTarget']));

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
}