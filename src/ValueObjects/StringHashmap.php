<?php


namespace Apie\CompositeValueObjects\ValueObjects;

use Apie\CompositeValueObjects\ValueObjectHashmapTrait;
use Apie\CompositeValueObjects\ValueObjectListInterface;
use Apie\TypeJuggling\StringLiteral;
use Apie\TypeJuggling\TypeUtilInterface;

final class StringHashmap implements ValueObjectListInterface
{
    use ValueObjectHashmapTrait;

    protected static function getWantedType(string $fieldName): TypeUtilInterface
    {
        return new StringLiteral($fieldName);
    }
}
