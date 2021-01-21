<?php

namespace Apie\Tests\CompositeValueObjects\ValueObjects;

use Apie\CompositeValueObjects\ValueObjects\IntegerList;
use Apie\CompositeValueObjects\ValueObjects\StringList;
use PHPUnit\Framework\TestCase;

class IntegerListTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_list_integers()
    {
        $testItem = IntegerList::fromNative(['2', '3', 1]);
        $this->assertEquals([2, 3, 1], $testItem->toNative());
        $this->assertSame(1, $testItem[2]);
    }
}
