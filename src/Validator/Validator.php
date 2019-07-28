<?php

namespace App\Validator;

use Illuminate\Contracts\Translation\Translator;
use PhpSlang\Either\Either;

interface Validator
{
    public function validate(
        array $data,
        array $rules,
        Translator $translator,
        callable $errorHandler = null,
        array $messages = []
    ): Either;
}