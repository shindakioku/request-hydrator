<?php

namespace RequestHydrator\Reflection;

use function Functional\curry;
use function Functional\filter;

class PhpReflection implements Reflection
{
    public const LANGUAGE_TYPES = ['bool', 'int', 'float', 'string', 'array', 'object', 'callable', 'iterable'];

    /**
     * @var \ReflectionClass
     */
    private $class;

    public function properties(): array
    {
        return $this->class->getProperties();
    }

    public function propertiesNames(): array
    {
        return \Functional\map($this->class->getProperties(), function ($value) {
            ;
            return $value->name;
        });
    }

    public function property(string $name): \ReflectionProperty
    {
        return $this->class->getProperty($name);
    }

    public function createBySettingsProperties(array $values)
    {
        $newInstance = $this->class->newInstanceWithoutConstructor();
        \Functional\each($values, function ($value, $key) use ($newInstance, $values) {
            $comments = $this->property($key)->getDocComment();

            // @TODO: Use generators
            if ($comments && ($strposVar = strpos($comments, '@var'))) {
                $substred = trim(explode('@var', substr($comments, $strposVar))[1]);
                $propertyDocType = trim(substr($substred, 0, strpos($substred, ' ')));

                if (!\Functional\contains(self::LANGUAGE_TYPES, $propertyDocType)) {
                    $propertyInstance = (new PhpReflection)->setClass($propertyDocType);
                    $curriedContains = curry(function (array $array, $key) use ($propertyInstance) {
                        return \Functional\contains($array, $key);
                    })($propertyInstance->propertiesNames());

                    return $newInstance->$key = $propertyInstance->createBySettingsProperties(
                        filter($values[$key], function ($_, $key) use ($curriedContains) {
                            return $curriedContains($key);
                        })
                    );
                }
            }

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