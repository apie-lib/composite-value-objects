<?php

namespace Apie\Tests\CompositeValueObjects\Utils;

use Apie\CompositeValueObjects\Exceptions\MissingValueException;
use Apie\CompositeValueObjects\Utils\Boolean;
use Apie\Tests\CompositeValueObjects\Mocks\ExampleWithMixedTypehint;
use PHPUnit\Framework\TestCase;

class BooleanTest extends TestCase
{
    /**
     * @dataProvider fromNativeProvider
     */
    public function testFromNative(bool $expected, $input)
    {
        $testItem = new Boolean('fieldName');
        $actual = $testItem->fromNative($input);
        $this->assertEquals($expected, $actual);
    }

    public function fromNativeProvider()
    {
        yield [false, false];
        yield [true, true];
        yield [false, null];
        yield [false, ''];
        yield [true, 'false'];
        yield [false, 0];
        yield [true, 1.5];
        yield [false, '0'];
        yield [false, []];
        yield [true, ['g' => 1]];
        yield [true, new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider supportsFromNativeProvider
     */
    public function testSupportsFromNative($expected, $input)
    {
        $testItem = new Boolean('fieldName');
        $this->assertEquals($expected, $testItem->supportsFromNative($input));
    }

    public function supportsFromNativeProvider()
    {
        yield [true, false];
        yield [true, true];
        yield [false, null];
        yield [false, ''];
        yield [false, 'false'];
        yield [false, 0];
        yield [false, 1.5];
        yield [false, '0'];
        yield [false, []];
        yield [false, ['g' => 1]];
        yield [false, new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider toNativeProvider
     */
    public function testToNative($expected, $input)
    {
        $testItem = new Boolean('fieldName');
        $this->assertEquals($expected, $testItem->toNative($input));
    }

    public function toNativeProvider()
    {
        yield [false, false];
        yield [true, true];
        yield [false, null];
        yield [false, ''];
        yield [true, 'false'];
        yield [false, 0];
        yield [true, 1.5];
        yield [false, '0'];
        yield [false, []];
        yield [true, ['g' => 1]];
        yield [true, new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider supportsProvider
     */
    public function testSupports($expected, $input)
    {
        $testItem = new Boolean('fieldName');
        $this->assertEquals($expected, $testItem->supports($input));
        $this->assertEquals($expected, $testItem->supportsToNative($input));
    }

    public function supportsProvider()
    {
        yield [true, false];
        yield [true, true];
        yield [false, null];
        yield [false, ''];
        yield [false, 'false'];
        yield [false, 0];
        yield [false, 1.5];
        yield [false, '0'];
        yield [false, []];
        yield [false, ['g' => 1]];
        yield [false, new ExampleWithMixedTypehint(false)];
    }

    public function testFromMissingValue()
    {
        $testItem = new Boolean('fieldName');
        $this->expectException(MissingValueException::class);
        $testItem->fromMissingValue();
    }

    public function testToString()
    {
        $testItem = new Boolean('fieldName');
        $this->assertEquals('bool', $testItem->__toString());
    }
}
