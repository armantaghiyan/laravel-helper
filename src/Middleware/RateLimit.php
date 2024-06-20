<?php

namespace Arman\LaravelHelper\Middleware;

use Arman\LaravelHelper\Exceptions\RateLimitException;
use Arman\LaravelHelper\Extras\Helper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;

class RateLimit {

	/**
	 * Handle an incoming request.
	 *
	 * @param Request  $request
	 * @param \Closure $next
	 * @param int      $maxAttempts
	 *
	 * @return mixed
	 * @throws RateLimitException
	 */
	public function handle(Request $request, Closure $next, int $maxAttempts = 60): mixed {
		$key = $this->throttleKey($request);

		if (RateLimiter::tooManyAttempts($key, $perMinute = $maxAttempts)) {
			throw new RateLimitException();
		}

		RateLimiter::increment($key);

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
		$baseIdentifier = request()->getMethod() . '|' . request()->ajax() . '|' . request()->getPathInfo() . '|' . request()->ip();

		if ($user = request()->user()) {
			return sha1(Str::lower($user->getAuthIdentifier() . '|' . $baseIdentifier));
		}

		return sha1(Str::lower($baseIdentifier));
	}
}
