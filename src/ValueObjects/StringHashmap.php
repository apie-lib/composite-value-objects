<?php


namespace Apie\CompositeValueObjects\ValueObjects;

use Apie\CompositeValueObjects\Factory\ReflectionTypeFactory;
use Apie\CompositeValueObjects\ValueObjectHashmapTrait;
use Apie\CompositeValueObjects\ValueObjectListInterface;
use Apie\CompositeValueObjects\ValueObjectListTrait;
use ReflectionType;

final class StringHashmap implements ValueObjectListInterface
{
    use ValueObjectHashmapTrait;

    protected static function getWantedType(): ReflectionType
    {
        return ReflectionTypeFactory::createString(false);
    }
}