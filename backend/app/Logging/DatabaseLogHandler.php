<?php

namespace App\Logging;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use Illuminate\Support\Facades\DB;

class DatabaseLogHandler extends AbstractProcessingHandler
{
    protected string $channelName;

    public function __construct(string $channelName, $level = \Monolog\Level::Debug, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
        $this->channelName = $channelName;
    }

    protected function write(LogRecord $record): void
    {

        DB::table('logs')->insert([
            'channel'    => $this->channelName, 
            'level'      => strtoupper($record->level->name),
            'user'    => $record->context['user_id'] ?? '',
            'class'      => $record->context['class'],
            'method'     => $record->context['method'],
            'action'     => $record->context['action'],
            'exception'  => isset($record->context['excpetion']) ? json_encode($record->context['excpetion']) : null,
            'payload'    => isset($record->context['payload']) ? json_encode($record->context['payload']) : null,
            'response'   => isset($record->context['response']) ? json_encode($record->context['response']) : null,
            'created_at' => $record->datetime,
            'updated_at' => $record->datetime,
        ]);
    }
}