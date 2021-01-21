<?php

namespace Apie\Tests\CompositeValueObjects\ValueObjects;

use Apie\CompositeValueObjects\ValueObjects\StringList;
use PHPUnit\Framework\TestCase;

class StringListTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_list_strings()
    {
        $testItem = StringList::fromNative(['a', 'b', 1]);
        $this->assertEquals(['a', 'b', '1'], $testItem->toNative());
        $this->assertSame('1', $testItem[2]);
    }
}
