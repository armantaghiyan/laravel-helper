<?php

namespace Arman\LaravelHelper\Helpers;

use Arman\LaravelHelper\Exceptions\ValidationException;
use Illuminate\Validation\Validator;

trait WithApiValidator
{

    /**
     * @throws ValidationException
     */
    public function withValidator(Validator $validator): void
    {
        if ($validator->fails()) {
            if ($validator->fails()) {
                throw new ValidationException($validator->errors()->first());
            }
        }
    }
}
