<?php

namespace Apie\Tests\CompositeValueObjects\Mocks;

use Apie\CompositeValueObjects\Factory\ReflectionTypeFactory;
use Apie\CompositeValueObjects\ValueObjectListInterface;
use Apie\CompositeValueObjects\ValueObjectListTrait;
use ReflectionType;

class ValueObjectListExample implements ValueObjectListInterface
{
    use ValueObjectListTrait;

    protected static function getWantedType(): ReflectionType
    {
        return ReflectionTypeFactory::createForClass(ExampleWithMissingTypehint::class);
    }
}