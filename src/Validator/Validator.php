<?php

namespace App\Validator;

use PhpSlang\Either\Either;

interface Validator
{
    public function validate(
        array $data,
        array $rules,
        callable $errorHandler = null,
        array $messages = []
    ): Either;
}