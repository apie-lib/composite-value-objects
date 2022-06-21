<?php
namespace Apie\Tests\CompositeValueObjects;

use Apie\CommonValueObjects\Enums\Gender;
use Apie\Fixtures\Enums\ColorEnum;
use Apie\Fixtures\ValueObjects\CompositeValueObjectExample;
use PHPUnit\Framework\TestCase;

class CompositeValueObjectTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_create_a_value_object_from_an_array()
    {
        $testItem = CompositeValueObjectExample::fromNative([
            'string' => 12,
            'integer' => 42,
            'floatingPoint' => 1.5,
            'trueOrFalse' => true,
            'mixed' => [],
            'color' => ColorEnum::RED->value,
        ]);
        $this->assertEquals('12', $testItem->getString());
        $this->assertEquals(42, $testItem->getInteger());
        $this->assertEquals(1.5, $testItem->getFloatingPoint());
        $this->assertEquals(true, $testItem->getTrueOrFalse());
        $this->assertEquals([], $testItem->getMixed());
        $this->assertEquals(ColorEnum::RED, $testItem->getColor());
    }
}
