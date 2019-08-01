<?php

namespace RequestHydrator\Validator;

use PhpSlang\Either\{Either, Left, Right};
use Illuminate\Contracts\Validation\Factory;

class IlluminateValidator implements Validator
{
    /**
     * @var Factory
     */
    private $validator;

    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    public function validate(
        array $data,
        array $rules,
        array $messages = []
    ): Either {
        try {
            return new Right($this->validator->make($data, $rules, $messages)->validate());
        } catch (\Exception $e) {
            return new Left($e);
        }
    }
}
