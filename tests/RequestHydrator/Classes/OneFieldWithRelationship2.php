<?php

namespace Tests\RequestHydrator\Classes;

use RequestHydrator\Dto\DtoHydrator;

class OneFieldWithRelationship2 implements DtoHydrator
{
    public $lastName;

    public function rules(): array
    {
        return [
            'lastName' => 'required',
        ];
    }

    public function messages()
    {
        // TODO: Implement messages() method.
    }
}