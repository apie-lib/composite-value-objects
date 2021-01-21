<?php

namespace Apie\Tests\CompositeValueObjects\Utils;

use Apie\CompositeValueObjects\Exceptions\MissingValueException;
use Apie\CompositeValueObjects\Exceptions\OnlyValueObjectInterfaceSupportException;
use Apie\CompositeValueObjects\Utils\AnotherValueObject;
use Apie\Tests\CompositeValueObjects\Mocks\ExampleWithMixedTypehint;
use Apie\Tests\CompositeValueObjects\Mocks\ValueObjectListExample;
use PHPUnit\Framework\TestCase;

class AnotherValueObjectTest extends TestCase
{
    /**
     * @test
     */
    public function this_only_works_value_object_interface_classes()
    {
        $this->expectException(OnlyValueObjectInterfaceSupportException::class);
        new AnotherValueObject('fieldName', __CLASS__);
    }

    public function testFromNative()
    {
        $testItem = new AnotherValueObject('fieldName', ExampleWithMixedTypehint::class);
        $actual = $testItem->fromNative(['mixed' => 'fiets']);
        $this->assertInstanceOf(ExampleWithMixedTypehint::class, $actual);
        $this->assertEquals('fiets', $actual->getMixed());
    }

    /**
     * @dataProvider fromNativeProvider
     */
    public function testSupportsFromNative($expected, $input)
    {
        $testItem = new AnotherValueObject('fieldName', ExampleWithMixedTypehint::class);
        $this->assertEquals($expected, $testItem->supportsFromNative($input));
    }

    public function fromNativeProvider()
    {
        yield [true, 'fiets'];
        yield [true, ['mixed' => 'fiets']];
        yield [true, new ExampleWithMixedTypehint('fiets')];
    }

    /**
     * @dataProvider toNativeProvider
     */
    public function testToNative($expected, $input)
    {
        $testItem = new AnotherValueObject('fieldName', ExampleWithMixedTypehint::class);
        $this->assertEquals($expected, $testItem->toNative($input));
    }

    public function toNativeProvider()
    {
        yield [null, 'fiets'];
        yield [['mixed' => 'fiets'], new ExampleWithMixedTypehint('fiets')];
    }

    /**
     * @dataProvider supportsProvider
     */
    public function testSupports($expected, $input)
    {
        $testItem = new AnotherValueObject('fieldName', ExampleWithMixedTypehint::class);
        $this->assertEquals($expected, $testItem->supports($input));
        $this->assertEquals($expected, $testItem->supportsToNative($input));
    }

    public function supportsProvider()
    {
        yield [false, 'fiets'];
        yield [true, new ExampleWithMixedTypehint('fiets')];
        yield [false, 12];
        yield [false, [new ExampleWithMixedTypehint('fiets')]];
        yield [false, ['mixed' => 'fiets']];
        yield [false, new ValueObjectListExample()];
    }

    public function testFromMissingValue()
    {
        $testItem = new AnotherValueObject('fieldName', ExampleWithMixedTypehint::class);
        $this->expectException(MissingValueException::class);
        $testItem->fromMissingValue();
    }

    public function testToString()
    {
        $testItem = new AnotherValueObject('fieldName', ExampleWithMixedTypehint::class);
        $this->assertEquals(ExampleWithMixedTypehint::class, $testItem->__toString());
    }
}
