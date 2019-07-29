<?php

namespace RequestHydrator\Validator;

use Illuminate\Contracts\Translation\Translator;
use PhpSlang\Either\{Either, Left, Right};
use Illuminate\Validation\Validator as IValidator;

class IlluminateValidator implements Validator
{
    private Translator $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function validate(
        array $data,
        array $rules,
        array $messages = []
    ): Either {
        $validator = new IValidator($this->translator, $data, $rules, $messages);

        try {
            return new Right($validator->validate());
        } catch (\Exception $e) {
            return new Left($e);
        }
    }
}