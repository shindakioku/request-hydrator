<?php

namespace RequestHydrator\Dto;

abstract class DtoHydrator
{
    public abstract function rules(): array;

    public function messages(): array
    {
        return [];
    }
}