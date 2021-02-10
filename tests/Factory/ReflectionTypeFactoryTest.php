<?php

namespace Apie\Tests\CompositeValueObjects\Factory;

use Apie\TypeJuggling\Factory\ReflectionTypeFactory;
use PHPUnit\Framework\TestCase;

class ReflectionTypeFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function can_create_string_reflection_type()
    {
        $this->assertEquals('string', ReflectionTypeFactory::createString(false)->getName());
        $this->assertFalse(ReflectionTypeFactory::createString(false)->allowsNull());
        $this->assertEquals('string', ReflectionTypeFactory::createString(true)->getName());
        $this->assertTrue(ReflectionTypeFactory::createString(true)->allowsNull());
    }

    /**
     * @test
     */
    public function can_create_int_reflection_type()
    {
        $this->assertEquals('int', ReflectionTypeFactory::createInt(false)->getName());
        $this->assertFalse(ReflectionTypeFactory::createInt(false)->allowsNull());
        $this->assertEquals('int', ReflectionTypeFactory::createInt(true)->getName());
        $this->assertTrue(ReflectionTypeFactory::createInt(true)->allowsNull());
    }

    /**
     * @test
     */
    public function can_create_class_reflection_type()
    {
        $this->assertEquals(__CLASS__, ReflectionTypeFactory::createForClass(__CLASS__)->getName());
        $this->assertFalse(ReflectionTypeFactory::createInt(false)->allowsNull());
    }
}
