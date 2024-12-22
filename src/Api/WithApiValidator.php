<?php

namespace Arman\LaravelHelper\Api;

use Arman\LaravelHelper\Exceptions\ValidationException;
use Illuminate\Validation\Validator;

trait WithApiValidator {

	/**
	 * @throws ValidationException
	 */
	public static function withValidator(Validator $validator): void {
		if ($validator->fails()) {
			if ($validator->fails()) {
				throw new ValidationException($validator->errors());
			}
		}
	}
}
