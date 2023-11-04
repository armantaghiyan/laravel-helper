<?php

namespace Arman\LaravelHelper\Exceptions;

use Arman\LaravelHelper\Helpers\Api;
use Arman\LaravelHelper\Helpers\StatusCodes;
use Illuminate\Http\JsonResponse;

class ErrorMessageException extends \Exception
{
    public function __construct(
        public $message,
        public $status = StatusCodes::Ok
    )
    {
        parent::__construct($message, $status);
    }

    public function render(): JsonResponse
    {
        return Api::cast(['message' => $this->getMessage()], $this->status, 'error_message');
    }
}
