<?php

namespace App\Reflection;

class PhpReflection implements Reflection
{
    private \ReflectionClass $class;

    public function properties(): array
    {
        return $this->class->getProperties();
    }

    public function property(string $name): \ReflectionProperty
    {
        return $this->class->getProperty($name);
    }

    public function createBySettingsProperties(array $values)
    {
        $newInstance = $this->class->newInstanceWithoutConstructor();
        \Functional\each($values, fn ($value, $key) => $newInstance->$key = $value);

        return $newInstance;
    }

    public function setClass(string $klass): Reflection
    {
        $this->class = new \ReflectionClass($klass);

        return $this;
    }
}