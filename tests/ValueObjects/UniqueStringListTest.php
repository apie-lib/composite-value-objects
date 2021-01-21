<?php

namespace Apie\Tests\CompositeValueObjects\ValueObjects;

use Apie\CompositeValueObjects\ValueObjects\UniqueStringList;
use PHPUnit\Framework\TestCase;

class UniqueStringListTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_list_strings()
    {
        $testItem = UniqueStringList::fromNative(['a', 'b', 1, '2', '1']);
        $this->assertEquals(['a', 'b', '1', '2'], $testItem->toNative());
        $this->assertSame('1', $testItem[2]);
    }
}
