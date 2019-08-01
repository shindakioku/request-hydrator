<?php

namespace RequestHydrator\Reflection;

class PhpReflection implements Reflection
{
    /**
     * @var \ReflectionClass
     */
    private $class;

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
        \Functional\each($values, function($value, $key) use ($newInstance) {
            $newInstance->$key = $value;
        });

        return $newInstance;
    }

    public function instanceWithoutConstructor()
    {
        return $this->class->newInstanceWithoutConstructor();
    }

    public function setClass($klass): Reflection
    {
        $this->class = new \ReflectionClass($klass);

        return $this;
    }
}