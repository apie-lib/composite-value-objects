<?php

namespace Apie\Tests\CompositeValueObjects\Utils;

use Apie\CompositeValueObjects\Exceptions\MissingValueException;
use Apie\CompositeValueObjects\Utils\Integer;
use Apie\CompositeValueObjects\Utils\StringLiteral;
use Apie\Tests\CompositeValueObjects\Mocks\ExampleWithMixedTypehint;
use PHPUnit\Framework\TestCase;

class StringLiteralTest extends TestCase
{
    /**
     * @dataProvider fromNativeProvider
     */
    public function testFromNative($expected, $input)
    {
        $testItem = new StringLiteral('fieldName');
        $actual = $testItem->fromNative($input);
        $this->assertEquals($expected, $actual);
    }

    public function fromNativeProvider()
    {
        yield ['', false];
        yield ['1', true];
        yield ['', null];
        yield ['', ''];
        yield ['false', 'false'];
        yield ['0', 0];
        yield ['1.5', 1.5];
        yield ['0', '0'];
        yield ['array', []];
        yield ['array', ['g' => 1]];
        yield ['array', new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider supportsFromNativeProvider
     */
    public function testSupportsFromNative($expected, $input)
    {
        $testItem = new StringLiteral('fieldName');
        $this->assertEquals($expected, $testItem->supportsFromNative($input));
        $this->assertEquals($expected, $testItem->supportsToNative($input));
    }

    public function supportsFromNativeProvider()
    {
        yield [false, false];
        yield [false, true];
        yield [false, null];
        yield [true, ''];
        yield [true, 'false'];
        yield [false, 0];
        yield [true, '0'];
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
        $testItem = new StringLiteral('fieldName');
        $this->assertEquals($expected, $testItem->toNative($input));
    }

    public function toNativeProvider()
    {
        yield ['', false];
        yield ['1', true];
        yield ['', null];
        yield ['', ''];
        yield ['false', 'false'];
        yield ['0', 0];
        yield ['1.5', 1.5];
        yield ['0', '0'];
        yield ['array', []];
        yield ['array', ['g' => 1]];
        yield ['array', new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider supportsProvider
     */
    public function testSupports($expected, $input)
    {
        $testItem = new StringLiteral('fieldName');
        $this->assertEquals($expected, $testItem->supports($input));
    }

    public function supportsProvider()
    {
        yield [true, false];
        yield [true, true];
        yield [false, null];
        yield [true, ''];
        yield [true, 'false'];
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
        $testItem = new StringLiteral('fieldName');
        $this->expectException(MissingValueException::class);
        $testItem->fromMissingValue();
    }

    public function testToString()
    {
        $testItem = new StringLiteral('fieldName');
        $this->assertEquals('string', $testItem->__toString());
    }
}
