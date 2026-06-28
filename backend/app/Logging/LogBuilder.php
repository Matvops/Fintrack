<?php

namespace App\Logging;

use App\Enums\ActionEnum;
use Exception;

abstract class LogBuilder implements LogCommand {

    protected ?int $userId;
    protected ?string $channel;
    protected ?string $class;
    protected ?string $method;
    protected ?ActionEnum $action;
    protected ?Exception $exception = null;
    protected mixed $payload = null;
    protected mixed $response = null;

    protected function adapter() {
        return [
            'channel' => $this->channel,
            'class' => $this->class,
            'method' => $this->method,
            'action' => $this->action->value,
            'exception' => $this->exception ? $this->exception->getMessage() . ' ' . $this->exception->getTraceAsString() : null,
            'payload' => $this->payload,
            'response' => $this->response,
            'user_id' => $this->userId,
        ];
    }

    public function setUserId(int $userId) {
        $this->userId = $userId;
    }

    public function setClass(string $class) {
        $this->class = $class;
    }

    public function setMethod(string $method) {
        $this->method = $method;
    }

    public function setAction(ActionEnum $action) {
        $this->action = $action;
    }

    public function setException(Exception $exception) {
        $this->exception = $exception;
    }

    public function setPayload(mixed $payload) {
        $this->payload = $payload;
    }

    public function setResponse(mixed $response) {
        $this->response = $response;
    }

    public function setChannel(mixed $channel) {
        $this->channel = $channel;
    }

    protected abstract function toTransaction();
    protected abstract function toBudget();
    protected abstract function toGoal();
    protected abstract function toDashboard();
}