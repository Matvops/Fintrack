<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\TransactionRepository;
use App\Utils\Response;
use Carbon\Carbon;
use Exception;

class DashboardService
{

    private TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function getDashboardData(int $id): Response
    {
        try {

            $transactions = $this->transactionRepository->getTransactionsByUseId($id);

            if (count($transactions) < 1) throw new NotFoundException("Sem Transações");

            $data = [
                'income' => 0,
                'expense' => 0,
                'balance' => 0,
                'peerBudgets' => [],
                'peerMonths' => []
            ];

            foreach ($transactions as $transaction) {

                $month = strtolower($transaction->tra_date->translatedFormat('F'));

                if ($transaction->tra_type === 'INCOME') {
                    $data['income'] += $transaction->tra_value;

                    $data['peerMonths'][$month]['income'] =  isset($data['peerMonths'][$month]['income']) ?
                        $data['peerMonths'][$month]['income'] + $transaction->tra_value : $transaction->tra_value;
                }

                if ($transaction->tra_type === 'EXPENSE') {
                    $data['expense'] += $transaction->tra_value;

                    $budget = $transaction->budget;
                    
                    $data['peerBudgets'][$budget->bdt_name]['color'] = $transaction->budget->bdt_color;
                    
                    $data['peerBudgets'][$budget->bdt_name]['value'] = isset($data['peerBudgets'][$budget->bdt_name]['value']) ?
                        $data['peerBudgets'][$budget->bdt_name]['value'] + $transaction->tra_value : $transaction->tra_value;

                    $data['peerMonths'][$month]['expense'] =  isset($data['peerMonths'][$month]['expense']) ?
                        $data['peerMonths'][$month]['expense'] + $transaction->tra_value : $transaction->tra_value;
                }
            }



            $data['balance'] = number_format($data['income'] - $data['expense'], 2, '.', '');
            $data['income'] = number_format($data['income'], 2, '.', '');
            $data['expense'] = number_format($data['expense'], 2, '.', '');

            $dataMonths = [];
            foreach ($data['peerMonths'] as $month => $values) {
                $dataMonths[] = [
                    'month' => $month,
                    'Receitas' => isset($values['income']) ? $values['income'] : '0.00',
                    'Despesas' => isset($values['expense']) ? $values['expense'] : '0.00',
                ];
            }

            $data['peerMonths'] = $dataMonths;

            $dataBudgets = [];
            foreach($data['peerBudgets'] as $budget => $value) {
                $dataBudgets[] = [
                    'name' => $budget,
                    'value' => doubleval($value['value']),
                    'color' => strtolower($value['color'])
                ];
            }

            $data['peerBudgets'] = $dataBudgets;

            return Response::getResponse(true, 'Valores encontrados', $data);
        } catch (NotFoundException $e) {
            return Response::getResponse(false, $e->getMessage(), code: $e->getCode());
        } catch (Exception $e) {
            return Response::getResponse(false, 'Erro ao localizar valores', code: $e->getCode());
        }
    }
}
