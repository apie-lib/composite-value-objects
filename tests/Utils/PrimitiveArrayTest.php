<?php

namespace Apie\Tests\CompositeValueObjects\Utils;

use Apie\CompositeValueObjects\Exceptions\MissingValueException;
use Apie\CompositeValueObjects\Utils\Integer;
use Apie\CompositeValueObjects\Utils\PrimitiveArray;
use Apie\Tests\CompositeValueObjects\Mocks\ExampleWithMixedTypehint;
use PHPUnit\Framework\TestCase;

class PrimitiveArrayTest extends TestCase
{
    /**
     * @dataProvider fromNativeProvider
     */
    public function testFromNative($expected, $input)
    {
        $testItem = new PrimitiveArray('fieldName');
        $actual = $testItem->fromNative($input);
        $this->assertEquals($expected, $actual);
    }

    public function fromNativeProvider()
    {
        yield [[], []];
        yield [['g' => 1], ['g' => 1]];
        yield [['mixed' => false], new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider supportsFromNativeProvider
     */
    public function testSupportsFromNative($expected, $input)
    {
        $testItem = new PrimitiveArray('fieldName');
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
        yield [false, 0];
        yield [false, '0'];
        yield [false, 1.5];
        yield [true, []];
        yield [true, ['g' => 1]];
        yield [false, new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider toNativeProvider
     */
    public function testToNative($expected, $input)
    {
        $testItem = new PrimitiveArray('fieldName');
        $this->assertEquals($expected, $testItem->toNative($input));
    }

    public function toNativeProvider()
    {
        yield [[false], false];
        yield [[true], true];
        yield [[], null];
        yield [[''], ''];
        yield [['false'], 'false'];
        yield [[0], 0];
        yield [[1.5], 1.5];
        yield [['0'], '0'];
        yield [[], []];
        yield [['g' => 1], ['g' => 1]];
        yield [['mixed' => false], new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider supportsProvider
     */
    public function testSupports($expected, $input)
    {
        $testItem = new PrimitiveArray('fieldName');
        $this->assertEquals($expected, $testItem->supports($input));
    }

    public function supportsProvider()
    {
        yield [false, false];
        yield [false, true];
        yield [false, null];
        yield [false, ''];
        yield [false, 'false'];
        yield [false, 0];
        yield [false, '0'];
        yield [false, 1.5];
        yield [false, '1.5'];
        yield [true, []];
        yield [true, ['g' => 1]];
        yield [true, new ExampleWithMixedTypehint(false)];
    }

    public function testFromMissingValue()
    {
        $testItem = new PrimitiveArray('fieldName');
        $this->expectException(MissingValueException::class);
        $testItem->fromMissingValue();
    }

    public function testToString()
    {
        $testItem = new PrimitiveArray('fieldName');
        $this->assertEquals('array', $testItem->__toString());
    }
}
