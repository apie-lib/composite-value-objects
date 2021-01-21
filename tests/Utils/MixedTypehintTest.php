<?php

namespace Apie\Tests\CompositeValueObjects\Utils;

    use Apie\CompositeValueObjects\Exceptions\MissingValueException;
    use Apie\CompositeValueObjects\Utils\MixedTypehint;
    use Apie\Tests\CompositeValueObjects\Mocks\ExampleWithMixedTypehint;
    use PHPUnit\Framework\TestCase;

class MixedTypehintTest extends TestCase
{
    /**
     * @dataProvider fromNativeProvider
     */
    public function testFromNative($expected, $input)
    {
        $testItem = new MixedTypehint('fieldName');
        $actual = $testItem->fromNative($input);
        $this->assertEquals($expected, $actual);
    }

    public function fromNativeProvider()
    {
        yield [false, false];
        yield [true, true];
        yield [null, null];
        yield ['', ''];
        yield ['false', 'false'];
        yield [0, 0];
        yield [1.5, 1.5];
        yield ['0', '0'];
        yield [[], []];
        yield [['g' => 1], ['g' => 1]];
        yield [new ExampleWithMixedTypehint(false), new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider supportsFromNativeProvider
     */
    public function testSupportsFromNative($expected, $input)
    {
        $testItem = new MixedTypehint('fieldName');
        $this->assertEquals($expected, $testItem->supportsFromNative($input));
        $this->assertEquals($expected, $testItem->supportsToNative($input));
    }

    public function supportsFromNativeProvider()
    {
        yield [true, false];
        yield [true, true];
        yield [true, null];
        yield [true, ''];
        yield [true, 'false'];
        yield [true, 0];
        yield [true, '0'];
        yield [true, 1.5];
        yield [true, []];
        yield [true, ['g' => 1]];
        yield [true, new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider toNativeProvider
     */
    public function testToNative($expected, $input)
    {
        $testItem = new MixedTypehint('fieldName');
        $this->assertEquals($expected, $testItem->toNative($input));
    }

    public function toNativeProvider()
    {
        yield [false, false];
        yield [true, true];
        yield [null, null];
        yield ['', ''];
        yield ['false', 'false'];
        yield [0, 0];
        yield [1.5, 1.5];
        yield ['0', '0'];
        yield [[], []];
        yield [['g' => 1], ['g' => 1]];
        yield [['mixed' => false], new ExampleWithMixedTypehint(false)];
    }

    /**
     * @dataProvider supportsProvider
     */
    public function testSupports($expected, $input)
    {
        $testItem = new MixedTypehint('fieldName');
        $this->assertEquals($expected, $testItem->supports($input));
    }

    public function supportsProvider()
    {
        yield [true, false];
        yield [true, true];
        yield [true, null];
        yield [true, ''];
        yield [true, 'false'];
        yield [true, 0];
        yield [true, '0'];
        yield [true, 1.5];
        yield [true, '1.5'];
        yield [true, []];
        yield [true, ['g' => 1]];
        yield [true, new ExampleWithMixedTypehint(false)];
    }

    public function testFromMissingValue()
    {
        $testItem = new MixedTypehint('fieldName');
        $this->expectException(MissingValueException::class);
        $testItem->fromMissingValue();
    }

    public function testToString()
    {
        $testItem = new MixedTypehint('fieldName');
        $this->assertEquals('mixed', $testItem->__toString());
    }

}
