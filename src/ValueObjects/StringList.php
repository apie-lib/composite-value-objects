<?php


namespace Apie\CompositeValueObjects\ValueObjects;

use Apie\CompositeValueObjects\Factory\ReflectionTypeFactory;
use Apie\CompositeValueObjects\ValueObjectListInterface;
use Apie\CompositeValueObjects\ValueObjectListTrait;
use ReflectionType;

final class StringList implements ValueObjectListInterface
{
    use ValueObjectListTrait;

    protected static function getWantedType(): ReflectionType
    {
        return ReflectionTypeFactory::createString(false);
    }
}