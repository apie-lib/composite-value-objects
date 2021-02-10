<?php


namespace Apie\Tests\CompositeValueObjects;

use Apie\Tests\CompositeValueObjects\Mocks\CompositeValueObjectExample;
use Apie\Tests\CompositeValueObjects\Mocks\CompositeValueObjectExampleWithTypehints;
use Apie\Tests\CompositeValueObjects\Mocks\ExampleWithArrayTypehint;
use Apie\Tests\CompositeValueObjects\Mocks\ExampleWithMissingTypehint;
use Apie\Tests\CompositeValueObjects\Mocks\ExampleWithMixedTypehint;
use PHPUnit\Framework\TestCase;

class CompositeValueObjectTraitTest extends TestCase
{
    /**
     * @test
     */
    public function can_convert_to_and_from_native()
    {
        $actual = CompositeValueObjectExample::fromNative(
            [
                'integer' => 12,
                'float' => 1.5,
                'recursive' => [
                    'integer' => 42,
                    'float' => 2.5,
                ]
            ]
        );
        $this->assertEquals(
            [
                'integer' => 12,
                'float' => 1.5,
                'nullableFloat' => null,
                'nullableInteger' => null,
                'recursive' => [
                    'integer' => 42,
                    'float' => 2.5,
                    'nullableFloat' => null,
                    'nullableInteger' => null,
                    'recursive' => null,
                ],
            ],
            $actual->toNative()
        );
    }

    /**
     * @test
     * @requires PHP >= 7.4
     */
    public function it_works_with_property_typehints()
    {
        $actual = CompositeValueObjectExampleWithTypehints::fromNative(
            [
                'integer' => 12,
                'float' => 1.5,
                'recursive' => [
                    'integer' => 42,
                    'float' => 2.5,
                ]
            ]
        );
        $this->assertEquals(
            [
                'integer' => 12,
                'float' => 1.5,
                'nullableFloat' => null,
                'nullableInteger' => null,
                'recursive' => [
                    'integer' => 42,
                    'float' => 2.5,
                    'nullableFloat' => null,
                    'nullableInteger' => null,
                    'recursive' => null,
                ],
            ],
            $actual->toNative()
        );
    }

    /**
     * @test
     */
    public function can_make_a_new_value_object_with_field_change()
    {
        $testItem = CompositeValueObjectExample::fromNative([
            'integer' => 12,
            'float' => 1.5,
        ]);
        $clonedItem = $testItem->with('float', '3.5');
        $this->assertEquals(1.5, $testItem->getFloat());
        $this->assertEquals(12, $clonedItem->getInteger());
        $this->assertEquals(3.5, $clonedItem->getFloat());
    }

    /**
     * @dataProvider mixedProvider
     * @test
     */
    public function it_works_with_mixed_typehint($input)
    {
        $testItem = ExampleWithMixedTypehint::fromNative([
            'mixed' => $input,
        ]);
        $this->assertEquals(['mixed' => $input], $testItem->toNative());
    }

    public function mixedProvider()
    {
        yield [null];
        yield [12];
        yield ["text"];
        yield [[]];
    }

    /**
     * @test
     * @dataProvider arrayProvider
     */
    public function it_works_with_array_typehint(array $input)
    {
        $testItem = ExampleWithArrayTypehint::fromNative([
            'mixedArray' => $input,
        ]);
        $this->assertEquals(['mixedArray' => $input], $testItem->toNative());
    }

    public function arrayProvider()
    {
        yield [[]];
        yield [[1]];
        yield [['a' => [12 => 3]]];
    }

    /**
     * @dataProvider mixedProvider
     * @test
     */
    public function it_works_without_typehint($input)
    {
        $testItem = ExampleWithMissingTypehint::fromNative([
            'noTypehint' => $input,
        ]);
        $this->assertEquals(['noTypehint' => $input], $testItem->toNative());
    }
}
