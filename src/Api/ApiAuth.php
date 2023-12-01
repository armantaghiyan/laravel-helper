<?php

namespace Arman\LaravelHelper\Api;

use Arman\LaravelHelper\Exceptions\NoTokenException;
use Illuminate\Contracts\Auth\Authenticatable;

trait ApiAuth
{

    /**
     * @throws NoTokenException
     */
    public function auth(string $gard = null): Authenticatable
    {
        $user = auth()->guard($gard ?? config('helper.default_auth_gard'))->user();

        if (!$user) {
            throw new NoTokenException();
        }

        return $user;
    }
}
