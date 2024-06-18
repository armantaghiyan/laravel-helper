<?php

namespace Arman\LaravelHelper\Middleware;

use Closure;
use Illuminate\Http\Request;

class CleanString {

    /**
     * Handle an incoming request.
     *
     * @param Request  $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next) {
        $request->merge($this->convertArrayNumbers($request->all()));

        return $next($request);
    }

    /**
     * Convert Persian numbers to English numbers in an array.
     *
     * @param array $input
     *
     * @return array
     */
    protected function convertArrayNumbers(array $input): array {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        array_walk_recursive($input, function (&$value) use ($persianNumbers, $englishNumbers) {
            if (is_string($value)) {
                $value = str_replace($persianNumbers, $englishNumbers, $value);
            }
        });

        return $input;
    }
}
