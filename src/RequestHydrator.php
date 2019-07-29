<?php

namespace RequestHydrator;

use RequestHydrator\Dto\DtoHydrator;
use RequestHydrator\Reflection\Reflection;
use RequestHydrator\Reflection\PhpReflection;
use RequestHydrator\Request\Request;
use RequestHydrator\Validator\Validator;
use PhpSlang\Either\{Either};

class RequestHydrator
{
    private Validator $validator;
    private Reflection $reflection;

    public function __construct(
        Validator $validator,
        ?Reflection $reflection = null
    ) {
        $this->validator = $validator;
        $this->reflection = $reflection ?? new PhpReflection;
    }

    public function queries(DtoHydrator $dtoHydrator, Request $request): Either
    {
        return $this->validateAndCreate($request->queries()->get(), $dtoHydrator);
    }

    public function headers(DtoHydrator $dtoHydrator, Request $request): Either
    {
        return $this->validateAndCreate($request->headers()->get(), $dtoHydrator);
    }

    public function body(DtoHydrator $dtoHydrator, Request $request): Either
    {
        return $this->validateAndCreate($request->body()->get(), $dtoHydrator);
    }

    private function validateAndCreate(array $values, DtoHydrator $dtoHydrator): Either
    {
        $this->reflection->setClass($dtoHydrator);

        return $this->validator->validate(
            $values, $dtoHydrator->rules(),
            $dtoHydrator->messages()
        )
            ->right(fn () => $this->reflection->createBySettingsProperties($values));
    }
}