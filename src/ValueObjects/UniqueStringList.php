<?php


namespace Apie\CompositeValueObjects\ValueObjects;

use Apie\CompositeValueObjects\Factory\ReflectionTypeFactory;
use Apie\CompositeValueObjects\ValueObjectListInterface;
use Apie\CompositeValueObjects\ValueObjectListTrait;
use ReflectionType;

final class UniqueStringList implements ValueObjectListInterface
{
    use ValueObjectListTrait;

    protected function sanitizeValue()
    {
        $this->list = array_values(array_unique($this->list));
    }

    protected static function getWantedType(): ReflectionType
    {
        return ReflectionTypeFactory::createString(false);
    }
}