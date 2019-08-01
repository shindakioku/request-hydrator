<?php

namespace RequestHydrator\Reflection;

interface Reflection
{
    public function properties(): array;

    public function propertiesNames(): array;

    public function property(string $name): \ReflectionProperty;

    public function instanceWithoutConstructor();

    public function setClass($klass): Reflection;
}