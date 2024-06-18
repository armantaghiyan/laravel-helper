<?php

namespace Arman\LaravelHelper\Middleware;

use Arman\LaravelHelper\Api\StatusCodes;
use Arman\LaravelHelper\Exceptions\ErrorMessageException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlockSuspiciousRequests {

	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure                 $next
	 *
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next): mixed {
		$suspiciousPatterns = [
			'/config\/pw_snmp_done\.html/',
			'/tos\/index\.php/',
			'/incom\/modules\/uploader\/showcase\/script\.php/',
			'/admin\/histograms/',

			'/<script.*?>.*?<\/script>/i',
			'/alert\(.*?\)/i',

			'/(\%27)|(\')|(\-\-)|(\%23)|(#)/i',
			'/((\%3D)|(=))[^\n]*((\%27)|(\')|(\-\-)|(\%3B)|(;))/i',
			'/\w*((\%27)|(\'))(\s|%20)*((\%4F)|(\%6F)|o|O|(\%4E)|(\%6E)|n|N)(\s|%20)*((\%53)|(\%73)|s|S|(\%48)|(\%68)|h|H|(\%49)|(\%69)|i|I|(\%54)|(\%74)|t|T|(\%2E)|(\%2e)|e|E)(\s|%20)*((\%41)|(\%61)|a|A|(\%4E)|(\%6E)|n|N|(\%44)|(\%64)|d|D)(\s|%20)*((\%41)|(\%61)|a|A|(\%49)|(\%69)|i|I)(\s|%20)*((\%54)|(\%74)|t|T|(\%4F)|(\%6F)|o|O|(\%50)|(\%70)|p|P)(\s|%20)*((\%4F)|(\%6F)|o|O|(\%52)|(\%72)|r|R)/i',
		];

		foreach ($suspiciousPatterns as $pattern) {
			if (preg_match($pattern, $request->getRequestUri()) || $this->containsSuspiciousPayload($request->all(), $pattern)) {
				Log::warning('Suspicious request blocked', ['url' => $request->fullUrl(), 'payload' => $request->all()]);
				throw new ErrorMessageException('forbidden', StatusCodes::Forbidden);
			}
		}

		return $next($request);
	}

	/**
	 *
	 * @param array  $payload
	 * @param string $pattern
	 *
	 * @return bool
	 */
	protected function containsSuspiciousPayload(array $payload, string $pattern): bool {
		foreach ($payload as $key => $value) {
			if (is_array($value)) {
				if ($this->containsSuspiciousPayload($value, $pattern)) {
					return true;
				}
			} elseif (preg_match($pattern, $key) || preg_match($pattern, $value)) {
				return true;
			}
		}
		return false;
	}
}
