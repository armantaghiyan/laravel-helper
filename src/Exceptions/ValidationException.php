<?php

namespace Arman\LaravelHelper\Exceptions;

use Arman\LaravelHelper\Api\Api;
use Arman\LaravelHelper\Api\StatusCodes;
use Illuminate\Http\JsonResponse;

class ValidationException extends \Exception
{
    public function __construct(
        public $message
    )
    {
        parent::__construct($message, StatusCodes::Bad_request);
    }

    public function render(): JsonResponse
    {
        return Api::cast(['message' => $this->getMessage()], $this->getCode(), 'error_validation');
    }
}
