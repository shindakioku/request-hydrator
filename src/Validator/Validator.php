<?php

namespace RequestHydrator\Validator;

use PhpSlang\Either\Either;

interface Validator
{
    public function validate(
        array $data,
        array $rules,
        array $messages = []
    ): Either;
}