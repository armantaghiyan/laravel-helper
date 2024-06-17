<?php

namespace Arman\LaravelHelper\Extras;

class Helper {

	public function getUserIp() {
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					$ip = trim($ip); // just to be safe
					if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
						return $ip;
					}
				}
			}
		}
		return request()->ip();
	}

	public function rs(string $relation, array $cols) {
		return "$relation:" . implode(',', $cols);
	}

	public function getServerMemoryUsage(): array {
		try {
			$free = shell_exec('free');
			$free = (string)trim($free);
			$free_arr = explode("\n", $free);

			$mem = explode(" ", $free_arr[1]);
			$mem = array_filter($mem);
			$mem = array_merge($mem);

			$memory_total = $mem[1];
			$memory_used = $mem[2];
			$percent_used = ($memory_used * 100) / $memory_total;

			return ['memory_total' => number_format((int)$memory_total), 'memory_used' => number_format((int)$memory_used), 'percent_used' => (int)$percent_used];
		} catch (\Throwable $exception) {
			return ['memory_total' => 0, 'memory_used' => 0, 'percent_used' => 0];
		}
	}

	public function getCPUUsage(): float|int {
		try {
			$cpu_usage = shell_exec('top -bn1 | grep "Cpu(s)"');
			preg_match('/\d+\.\d+ id/', $cpu_usage, $matches);
			$cpu_idle = floatval($matches[0]);
			return number_format(100 - $cpu_idle, 2);
		} catch (\Throwable $exception) {
			return 0;
		}
	}

	public function getBaseUrl(string $prefix, bool $withHttp = false): string {
		$url = explode('//', config('app.url'));
		return ($withHttp ? $url[0] . '//' : '') . ($prefix ? "$prefix." : '') . $url[1];
	}
}
