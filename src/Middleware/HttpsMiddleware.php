<?php

namespace Arman\LaravelHelper\Middleware;

use Closure;

class HttpsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        if (
            !$request->secure()
            && app()->environment('production')
        ) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
