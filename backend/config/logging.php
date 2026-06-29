<?php

use App\Logging\DatabaseLogger;
use Monolog\Handler\NullHandler;
use Monolog\Level;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that is utilized to write
    | messages to your logs. The value provided here should match one of
    | the channels present in the list of "channels" configured below.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */

    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
        'trace' => env('LOG_DEPRECATIONS_TRACE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Laravel
    | utilizes the Monolog PHP logging library, which includes a variety
    | of powerful log handlers and formatters that you're free to use.
    |
    | Available drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog", "custom", "stack"
    |
    */

    'channels' => [

        'stack' => [
            'driver' => 'stack',
            'channels' => explode(',', (string) env('LOG_STACK', 'single')),
            'ignore_exceptions' => false,
        ],

        'TRANSACTION' => [
            'driver' => 'custom',
            'channel' => 'TRANSACTION',
            'via' => DatabaseLogger::class,
            'level' => Level::Info,
        ],

        'BUDGET' => [
            'driver' => 'custom',
            'channel' => 'BUDGET',
            'via' => DatabaseLogger::class,
            'level' => Level::Info,
        ],

        'GOAL' => [
            'driver' => 'custom',
            'channel' => 'GOAL',
            'via' => DatabaseLogger::class,
            'level' => Level::Info,
        ],

        'DASHBOARD' => [
            'driver' => 'custom',
            'channel' => 'DASHBOARD',
            'via' => DatabaseLogger::class,
            'level' => Level::Info,
        ],

        'AUTH' => [
            'driver' => 'custom',
            'channel' => 'AUTH',
            'via' => DatabaseLogger::class,
            'level' => Level::Info,
        ],

        'INVALID_CHANNEL' => [
            'driver' => 'custom',
            'channel' => 'INVALID_CHANNEL',
            'via' => DatabaseLogger::class,
            'level' => Level::Info,
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
            'facility' => env('LOG_SYSLOG_FACILITY', LOG_USER),
            'replace_placeholders' => true,
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

    ],

];
