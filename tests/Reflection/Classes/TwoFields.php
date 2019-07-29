<?php

namespace Tests\Reflection\Classes;

use App\Dto\DtoHydrator;

class TwoFields extends DtoHydrator
{
    public string $username;
    public string $password;

    public function rules(): array
    {
        return [
            'username' => 'required',
            'password' => 'string',
        ];
    }
}