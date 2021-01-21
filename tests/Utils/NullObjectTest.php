<?php

namespace Apie\Tests\CompositeValueObjects\Utils;

use Apie\CompositeValueObjects\Exceptions\MissingValueException;
use Apie\CompositeValueObjects\Utils\Integer;
use Apie\CompositeValueObjects\Utils\NullObject;
use Apie\Tests\CompositeValueObjects\Mocks\ExampleWithMixedTypehint;
use PHPUnit\Framework\TestCase;

class NullObjectTest extends TestCase
{
    /**
     * @dataProvider fromNativeProvider
     */
    public function testFromNative($expected, $input)
    {
        $testItem = new NullObject();
        $actual = $testItem->fromNative($input);
        $this->assertEquals($expected, $actual);
    }

    public function fromNativeProvider()
    {
        yield [null, false];
        yield [null, true];
        yield [null, null];
        yield [null, ''];
        yield [null, 'false'];
        yield [null, 0];
        yield [null, 1.5];
        yield [null, '0'];
        yield [null, []];
        yield [null, ['g' => 1]];
        yield [null, new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider supportsFromNativeProvider
     */
    public function testSupportsFromNative($expected, $input)
    {
        $testItem = new NullObject();
        $this->assertEquals($expected, $testItem->supportsFromNative($input));
        $this->assertEquals($expected, $testItem->supportsToNative($input));
    }

    public function supportsFromNativeProvider()
    {
        yield [false, false];
        yield [false, true];
        yield [true, null];
        yield [false, ''];
        yield [false, 'false'];
        yield [false, 0];
        yield [false, '0'];
        yield [false, 1.5];
        yield [false, []];
        yield [false, ['g' => 1]];
        yield [false, new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider toNativeProvider
     */
    public function testToNative($expected, $input)
    {
        $testItem = new NullObject();
        $this->assertEquals($expected, $testItem->toNative($input));
    }

    public function toNativeProvider()
    {
        yield [null, false];
        yield [null, true];
        yield [null, null];
        yield [null, ''];
        yield [null, 'false'];
        yield [null, 0];
        yield [null, 1.5];
        yield [null, '0'];
        yield [null, []];
        yield [null, ['g' => 1]];
        yield [null, new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider supportsProvider
     */
    public function testSupports($expected, $input)
    {
        $testItem = new NullObject();
        $this->assertEquals($expected, $testItem->supports($input));
    }

    public function supportsProvider()
    {
        yield [false, false];
        yield [false, true];
        yield [true, null];
        yield [false, ''];
        yield [false, 'false'];
        yield [false, 0];
        yield [false, '0'];
        yield [false, 1.5];
        yield [false, '1.5'];
        yield [false, []];
        yield [false, ['g' => 1]];
        yield [false, new ExampleWithMixedTypehint(false)];
    }

    public function testFromMissingValue()
    {
        $testItem = new NullObject();
        $this->assertNull($testItem->fromMissingValue());
    }

    public function testToString()
    {
        $testItem = new NullObject();
        $this->assertEquals('null', $testItem->__toString());
    }
}
