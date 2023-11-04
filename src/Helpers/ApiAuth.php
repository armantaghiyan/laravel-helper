<?php

namespace Arman\LaravelHelper\Helpers;

use Arman\LaravelHelper\Exceptions\NoTokenException;
use Illuminate\Contracts\Auth\Authenticatable;

trait ApiAuth
{

    /**
     * @throws NoTokenException
     */
    public function auth(string $gard): Authenticatable
    {
        $user = auth()->guard($gard)->user();

        if (!$user) {
            throw new NoTokenException();
        }

        return $user;
    }
}
