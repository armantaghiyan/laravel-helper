<?php

namespace Arman\LaravelHelper\Exceptions;

use Arman\LaravelHelper\Api\Api;
use Arman\LaravelHelper\Api\StatusCodes;
use Illuminate\Http\JsonResponse;

class RateLimitException extends \Exception {

    public function __construct()
    {
        parent::__construct('rate_limit', StatusCodes::Many_requests);
    }

    public function render(): JsonResponse
    {
        return Api::cast(status: $this->getCode(), result: $this->getMessage());
    }
}
