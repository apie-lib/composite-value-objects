<?php

namespace Apie\Tests\CompositeValueObjects;

use Apie\Tests\CompositeValueObjects\Mocks\ExampleWithMissingTypehint;
use Apie\Tests\CompositeValueObjects\Mocks\ValueObjectListExample;
use PHPUnit\Framework\TestCase;

class ValueObjectListTraitTest extends TestCase
{
    /**
     * @test
     */
    public function i_can_create_a_class_list_value_object()
    {
        $list = [
            [
                'noTypehint' => 42,
            ],
            [
                'noTypehint' => "Pizza",
            ]
        ];

        $testItem = ValueObjectListExample::fromNative($list);
        $this->assertEquals(
            ExampleWithMissingTypehint::fromNative(['noTypehint' => 42]),
            $testItem[0]
        );
        $count = 0;
        foreach ($testItem as $item) {
            $this->assertInstanceOf(ExampleWithMissingTypehint::class, $item);
            $count++;
        }
        $this->assertEquals(2, $count);
        $this->assertEquals(2, $testItem->count());
        $this->assertEquals($list, $testItem->toNative());
    }
}
