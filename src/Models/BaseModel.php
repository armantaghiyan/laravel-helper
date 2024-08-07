<?php

namespace Arman\LaravelHelper\Models;

use Arman\LaravelHelper\Exceptions\ErrorMessageException;
use Arman\LaravelHelper\Api\StatusCodes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

trait BaseModel {

	public function correctImage(string $path, string|null $filename, $default = null, string $disk = null): ?string {
		if ($filename || $default) {
			$filename = $filename ?? $default;
			return Storage::disk($disk ?? config('helper.default_disk'))->url($path . $filename);
		}

		return null;
	}

	private function checkParam(mixed $value): bool {
		if ($value === null || $value === '')
			return false;

		return true;
	}

	public function scopePage(Builder $query, int $loadedCount, int $perPage = 20): Builder {
		return $query->skip($loadedCount)->limit($perPage);
	}

	public function scopeFilter(Builder $query, string $col, mixed $value): Builder {
		if ($this->checkParam($value)) {
			if (gettype($value) === 'string' && str_contains($value, '%')) {
				return $query->where($col, 'LIKE', $value);
			}

			return $query->where($col, $value);
		}

		return $query;
	}

	/**
	 * @throws ErrorMessageException
	 */
	public function scopeFirstOrError(Builder $query, array $cols = ['*'], string $message = 'not fount item.'): mixed {
		$result = $query->first($cols);

		if (!$result) {
			throw new ErrorMessageException($message, StatusCodes::Not_found);
		}

		return $result;
	}

	public function scopePage2(Builder $query, $perPage = 20) {
		$offset = ((int)request('page', 1) - 1) * $perPage;
		return $query->offset($offset)->limit($perPage);
	}
}
