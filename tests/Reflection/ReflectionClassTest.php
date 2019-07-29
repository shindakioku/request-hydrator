<?php

namespace Tests\Reflection;

use RequestHydrator\Reflection\PhpReflection;
use PHPUnit\Framework\TestCase;
use Tests\Reflection\Classes\TwoFields;

class ReflectionClassTest extends TestCase
{
    private PhpReflection $reflection;

    public function setUp(): void
    {
        $this->reflection = new PhpReflection;
    }

    public function testFields()
    {
        $this->reflection->setClass(TwoFields::class);
        $result = $this->reflection->createBySettingsProperties(['username' => 'shindakioku']);

        $this->assertTrue($result->username === 'shindakioku');
    }
}