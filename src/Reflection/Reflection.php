<?php

namespace App\Reflection;

interface Reflection
{
    public function properties(): array;

    public function property(string $name): \ReflectionProperty;

    public function setClass(string $klass): Reflection;
}