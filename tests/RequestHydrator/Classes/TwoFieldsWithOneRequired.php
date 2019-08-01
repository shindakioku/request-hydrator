<?php

namespace Tests\RequestHydrator\Classes;

use RequestHydrator\Dto\DtoHydrator;

class TwoFieldsWithOneRequired extends DtoHydrator
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    public function rules(): array
    {
        return [
            'username' => 'required',
            'email' => 'email'
        ];
    }
}