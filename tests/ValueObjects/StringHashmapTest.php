<?php

namespace Apie\Tests\CompositeValueObjects\ValueObjects;

use Apie\CompositeValueObjects\ValueObjects\StringHashmap;
use Apie\CompositeValueObjects\ValueObjects\StringList;
use PHPUnit\Framework\TestCase;

class StringHashmapTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_list_strings()
    {
        $testItem = StringHashmap::fromNative(['a' => 'b', 'b' => 'c', 1 => 2]);
        $this->assertEquals(
            [
                'a' => 'b',
                'b' => 'c',
                '1' => '2',
            ],
            $testItem->toNative()
        );
        $this->assertSame('2', $testItem[1]);
    }
}
