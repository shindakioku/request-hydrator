<?php

namespace App;

use App\Dto\DtoHydrator;
use App\Reflection\Reflection;
use App\Reflection\PhpReflection;
use App\Request\Request;
use App\Validator\Validator;

class RequestHydrator
{
    private Request $request;
    private Validator $validator;
    private Reflection $reflection;

    public function __construct(Request $request, Validator $validator, ?Reflection $reflection = null)
    {
        $this->request = $request;
        $this->validator = $validator;
        $this->reflection = $reflection ?? new PhpReflection;
    }

    public function queries(DtoHydrator $dtoHydrator)
    {
        $this->reflection->setClass($dtoHydrator);
        $fields = $this->reflection->properties();

        var_dump($fields);
    }
}