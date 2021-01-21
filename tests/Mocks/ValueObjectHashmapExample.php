<?php

namespace Apie\Tests\CompositeValueObjects\Mocks;

use Apie\CompositeValueObjects\Factory\ReflectionTypeFactory;
use Apie\CompositeValueObjects\ValueObjectListInterface;
use Apie\CompositeValueObjects\ValueObjectHashmapTrait;
use ReflectionType;

class ValueObjectHashmapExample implements ValueObjectListInterface
{
    use ValueObjectHashmapTrait;

    protected static function getWantedType(): ReflectionType
    {
        return ReflectionTypeFactory::createForClass(ExampleWithMissingTypehint::class);
    }
}