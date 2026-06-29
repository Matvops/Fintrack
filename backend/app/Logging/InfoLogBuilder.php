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
            case 'AUTH':
                $this->toAuth();
                break;
            default:
                $this->toInvalidChannel();
                break;
        }
    }

    #[Override]
    public function toBudget()
    {
        Log::channel('BUDGET')->info('', $this->adapter());
    }

    #[Override]
    public function toGoal()
    {
        Log::channel('GOAL')->info('', $this->adapter());
    }

    #[Override]
    public function toDashboard()
    {
        Log::channel('DASHBOARD')->info('', $this->adapter());
    }

    #[Override]
    public function toTransaction()
    {
        Log::channel('TRANSACTION')->info('', $this->adapter());
    }

    #[Override]
    public function toAuth()
    {
        Log::channel('AUTH')->info('', $this->adapter());
    }


    #[Override]
    public function toInvalidChannel()
    {
        Log::channel('INVALID_CHANNEL')->info('', $this->adapter());
    }
}