<?php

namespace App\Logging;

use Illuminate\Support\Facades\Log;
use Override;

class InfoLogBuilder extends LogBuilder {

    #[Override]
    public function execute()
    {
        switch($this->channel) {
            case 'BUDGET':
                $this->toBudget();
                break;
            case 'TRANSACTION':
                $this->toTransaction();
                break;
            case 'GOAL':
                $this->toGoal();
                break;
            case 'DASHBOARD':
                $this->toDashboard();
                break;
        }
    }

    #[Override]
    public function toBudget()
    {
        Log::channel('BUDGET_LOG')->info('', $this->adapter());
    }

    #[Override]
    public function toGoal()
    {
        Log::channel('GOAL_LOG')->info('', $this->adapter());
    }

    #[Override]
    public function toDashboard()
    {
        Log::channel('DASHBOARD_LOG')->info('', $this->adapter());
    }

    #[Override]
    public function toTransaction()
    {
        Log::channel('TRANSACTION_LOG')->info('', $this->adapter());
    }
}