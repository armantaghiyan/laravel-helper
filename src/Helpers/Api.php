<?php

namespace Arman\LaravelHelper\Helpers;

use Illuminate\Http\JsonResponse;

class Api
{
    public static function cast(array $data = [], int $status = StatusCodes::Ok, $result = 'success'): JsonResponse
    {
        $result = ['result' => $result, ...$data];
        return response()->json($result, $status);
    }

    public static function ok(): JsonResponse
    {
        return Api::cast();
    }
}
