<?php

namespace Tests\RequestHydrator\Classes;

use App\Dto\DtoHydrator;

class TwoFieldsWithOneRequired extends DtoHydrator
{
    public string $username;
    public string $email;

    public function rules(): array
    {
        return [
            'username' => 'required',
            'email' => 'email'
        ];
    }
}