<?php

namespace App\Logging;

use Monolog\Logger;
use App\Logging\DatabaseLogHandler;

class DatabaseLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @return Logger
     */
    public function __invoke(array $config)
    {
        $channel = $config['channel'] ?? 'database';

        return new Logger($channel, [
            new DatabaseLogHandler($channel),
        ]);
    }
}