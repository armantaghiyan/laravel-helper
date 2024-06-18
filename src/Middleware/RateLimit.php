<?php

namespace Arman\LaravelHelper\Middleware;

use Arman\LaravelHelper\Exceptions\RateLimitException;
use Arman\LaravelHelper\Extras\Helper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class RateLimit {

	/**
	 * Handle an incoming request.
	 *
	 * @param Request  $request
	 * @param \Closure $next
	 * @param int      $maxAttempts
	 * @param int      $decayMinutes
	 *
	 * @return mixed
	 * @throws RateLimitException
	 */
	public function handle(Request $request, Closure $next, int $maxAttempts = 60, int $decayMinutes = 1) {
		$key = $this->throttleKey($request);

		if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
			throw new RateLimitException();
		}

		RateLimiter::hit($key, $decayMinutes * 60);

		return $next($request);
	}

	/**
	 * Generate the rate limiting key for the request.
	 *
	 * @param Request $request
	 *
	 * @return string
	 */
	protected function throttleKey(Request $request): string {
		return Str::lower(Helper::getUserIp());
	}
}
