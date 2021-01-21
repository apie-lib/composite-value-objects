<?php

namespace Apie\Tests\CompositeValueObjects\Utils;

use Apie\CompositeValueObjects\Exceptions\MissingValueException;
use Apie\CompositeValueObjects\Utils\FloatingPoint;
use Apie\Tests\CompositeValueObjects\Mocks\ExampleWithMixedTypehint;
use PHPUnit\Framework\TestCase;

class FloatingPointTest extends TestCase
{
    /**
     * @dataProvider fromNativeProvider
     */
    public function testFromNative(float $expected, $input)
    {
        $testItem = new FloatingPoint('fieldName');
        $actual = $testItem->fromNative($input);
        $this->assertEquals($expected, $actual);
    }

    public function fromNativeProvider()
    {
        yield [0.0, false];
        yield [1.0, true];
        yield [0.0, null];
        yield [0.0, ''];
        yield [0.0, 'false'];
        yield [0.0, 0];
        yield [1.5, 1.5];
        yield [0.0, '0'];
        yield [0.0, []];
        yield [1.0, ['g' => 1]];
        yield [1.0, new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider supportsFromNativeProvider
     */
    public function testSupportsFromNative($expected, $input)
    {
        $testItem = new FloatingPoint('fieldName');
        $this->assertEquals($expected, $testItem->supportsFromNative($input));
        $this->assertEquals($expected, $testItem->supportsToNative($input));
    }

    public function supportsFromNativeProvider()
    {
        yield [false, false];
        yield [false, true];
        yield [false, null];
        yield [false, ''];
        yield [false, 'false'];
        yield [true, 0];
        yield [false, '0'];
        yield [true, 1.5];
        yield [false, []];
        yield [false, ['g' => 1]];
        yield [false, new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider toNativeProvider
     */
    public function testToNative($expected, $input)
    {
        $testItem = new FloatingPoint('fieldName');
        $this->assertEquals($expected, $testItem->toNative($input));
    }

    public function toNativeProvider()
    {
        yield [0.0, false];
        yield [1.0, true];
        yield [0.0, null];
        yield [0.0, ''];
        yield [0.0, 'false'];
        yield [0.0, 0];
        yield [1.5, 1.5];
        yield [0.0, '0'];
        yield [0.0, []];
        yield [1.0, ['g' => 1]];
        yield [1.0, new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider supportsProvider
     */
    public function testSupports($expected, $input)
    {
        $testItem = new FloatingPoint('fieldName');
        $this->assertEquals($expected, $testItem->supports($input));
    }

    public function supportsProvider()
    {
        yield [true, false];
        yield [true, true];
        yield [false, null];
        yield [false, ''];
        yield [false, 'false'];
        yield [true, 0];
        yield [true, '0'];
        yield [true, 1.5];
        yield [true, '1.5'];
        yield [false, []];
        yield [false, ['g' => 1]];
        yield [false, new ExampleWithMixedTypehint(false)];
    }

    public function testFromMissingValue()
    {
        $testItem = new FloatingPoint('fieldName');
        $this->expectException(MissingValueException::class);
        $testItem->fromMissingValue();
    }

    public function testToString()
    {
        $testItem = new FloatingPoint('fieldName');
        $this->assertEquals('float', $testItem->__toString());
    }
}
