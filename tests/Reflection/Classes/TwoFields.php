<?php

namespace Tests\Reflection\Classes;

use RequestHydrator\Dto\DtoHydrator;

class TwoFields extends DtoHydrator
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
}