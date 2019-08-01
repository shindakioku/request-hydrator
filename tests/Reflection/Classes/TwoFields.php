<?php

namespace Tests\Reflection\Classes;

use RequestHydrator\Dto\DtoHydrator;

class TwoFields implements DtoHydrator
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    public function rules(): array
    {
        return [
            'username' => 'required',
            'password' => 'string',
        ];
    }

    public function messages()
    {
        // TODO: Implement messages() method.
    }
}