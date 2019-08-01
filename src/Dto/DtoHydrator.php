<?php

namespace RequestHydrator\Dto;

interface DtoHydrator
{
    public function rules(): array;

    public function messages() /* array | void */;
}