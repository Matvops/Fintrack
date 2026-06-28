<?php

namespace App\Logging;

use App\Enums\ActionEnum;
use Exception;
use Illuminate\Support\Facades\Auth;

class LogInvoker {

    private LogBuilder $builder;

    private function __construct(LogBuilder $builder) 
    {
        $this->builder = $builder;
    }

    public static function update(LogBuilder $builder) {
        $builder->setAction(ActionEnum::UPDATE);
        return new LogInvoker($builder);
    }

    public static function create(LogBuilder $builder) {
        $builder->setAction(ActionEnum::CREATE);
        return new LogInvoker($builder);
    }

    public static function delete(LogBuilder $builder) {
        $builder->setAction(ActionEnum::DELETE);
        return new LogInvoker($builder);
    }

    public static function read(LogBuilder $builder) {
        $builder->setAction(ActionEnum::READ);
        return new LogInvoker($builder);
    }

    public static function upload(LogBuilder $builder) {
        $builder->setAction(ActionEnum::UPLOAD);
        return new LogInvoker($builder);
    }

    public static function download(LogBuilder $builder) {
        $builder->setAction(ActionEnum::DOWNLOAD);
        return new LogInvoker($builder);
    }

    public function withPayload(mixed $payload) {
        $this->builder->setPayload($payload);
        return $this;
    }

    public function withResponse(mixed $payload) {
        $this->builder->setResponse($payload);
        return $this;
    }

    public function save(string $channel, Exception|null $e = null) {
        $trace = debug_backtrace(limit: 2);
        $this->builder->setClass(basename(str_replace('\\', '/', debug_backtrace()[1]['class'])));
        $this->builder->setMethod($trace[1]['function']);
        $this->builder->setUserId(Auth::id());
        $this->builder->setChannel($channel);

        if($e) $this->builder->setException($e);

        $this->builder->execute();
    }
}