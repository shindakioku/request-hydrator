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
    /**
     * @var Validator
     */
    private $validator;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var PhpReflection|Reflection|null
     */
    private $reflection;

    public function __construct(
        Validator $validator,
        Request $request,
        ?Reflection $reflection = null
    ) {
        $this->validator = $validator;
        $this->request = $request;
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
            ->right(function () use ($values) {
                return $this->reflection->createBySettingsProperties($values);
            });
    }
}