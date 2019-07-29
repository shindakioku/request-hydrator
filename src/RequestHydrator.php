<?php

namespace App;

use App\Dto\DtoHydrator;
use App\Reflection\Reflection;
use App\Reflection\PhpReflection;
use App\Request\Request;
use App\Validator\Validator;
use PhpSlang\Either\{Either, Right, Left};

class RequestHydrator
{
    private Request $request;
    private Validator $validator;
    private Reflection $reflection;

    public function __construct(
        Request $request,
        Validator $validator,
        ?Reflection $reflection = null
    ) {
        $this->request = $request;
        $this->validator = $validator;
        $this->reflection = $reflection ?? new PhpReflection;
    }

    public function queries(DtoHydrator $dtoHydrator): Either
    {
        return $this->validateAndCreate($this->request->queries()->get(), $dtoHydrator);
    }

    public function headers(DtoHydrator $dtoHydrator): Either
    {
        return $this->validateAndCreate($this->request->headers()->get(), $dtoHydrator);
    }

    public function body(DtoHydrator $dtoHydrator): Either
    {
        return $this->validateAndCreate($this->request->body()->get(), $dtoHydrator);
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