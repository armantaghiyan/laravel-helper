<?php

namespace Arman\LaravelHelper\Auth;

use Arman\LaravelHelper\Exceptions\NoTokenException;
use Illuminate\Support\Facades\Auth;

trait WithAuth
{
    /**
     * @throws NoTokenException
     */
    function auth($guard = null): \Illuminate\Contracts\Auth\Authenticatable
    {
        $user = Auth::guard($guard ?? config('auth.defaults.guard'))->user();

        if (!$user) {
            throw new \Arman\LaravelHelper\Exceptions\NoTokenException();
        }

        return $user;
    }
}
