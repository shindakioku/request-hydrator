<?php

namespace App\Validator;

use Illuminate\Contracts\Translation\Translator;
use PhpSlang\Either\{Either, Left, Right};
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Illuminate\Validation\Validator as IValidator;

class IlluminateValidator implements Validator
{
    private Translator $translator;
    private $errorHandler;

    public function __construct(Translator $translator, callable $errorHandler = null)
    {
        $this->translator = $translator;
        $this->errorHandler = $errorHandler ?? function ($errors) {
                throw new BadRequestHttpException($errors);
            };
    }

    public function validate(
        array $data,
        array $rules,
        callable $errorHandler = null,
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