<?php

namespace Tests\RequestHydrator\Classes;

use RequestHydrator\Dto\DtoHydrator;

class OneFieldWithRelationship1 implements DtoHydrator
{
    public $name;

    /**
     * @var Tests\RequestHydrator\Classes\OneFieldWithRelationship2
     *
     */
    public $profile;

    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }

    public function messages()
    {
        // TODO: Implement messages() method.
    }
}