<?php

namespace App\Services;

use App\Models\Transaction;
use App\Utils\Functions;
use App\Utils\Response;
use Carbon\Carbon;
use Exception;

class TransactionService {

    public function create(array $data): Response
    {
        try {
            
            $transaction = new Transaction();
            $transaction->tra_use_id = $data['id'];
            $transaction->tra_bdt_id = $data['category'];
            $transaction->tra_description = $data['description'];
            $transaction->tra_value = Functions::formatValue($data['value']);
            $transaction->tra_date = Carbon::parse("{$data['date']} 00:00:00")->toDateTimeString(); 
            $transaction->tra_type = strtoupper($data['type']); 
            $transaction->save();

            return Response::getResponse(true, 'Transação cadastrada com sucesso');
        } catch(Exception $e) {
            error_log($e->getMessage());
            return Response::getResponse(false, 'Erro ao cadastrar transação');
        }
    }
}