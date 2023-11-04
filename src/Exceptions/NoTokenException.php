<?php

namespace Arman\LaravelHelper\Exceptions;

use Arman\LaravelHelper\Helpers\Api;
use Arman\LaravelHelper\Helpers\StatusCodes;
use Illuminate\Http\JsonResponse;

class NoTokenException extends \Exception
{
    public function __construct()
    {
        parent::__construct('no_token', StatusCodes::Unauthorized);
    }

    public function render(): JsonResponse
    {
        return Api::cast(status: $this->getCode(), result: $this->getMessage());
    }
}
