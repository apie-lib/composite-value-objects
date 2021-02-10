<?php


namespace Apie\CompositeValueObjects\ValueObjects;

use Apie\CompositeValueObjects\ValueObjectListInterface;
use Apie\CompositeValueObjects\ValueObjectListTrait;
use Apie\TypeJuggling\StringLiteral;
use Apie\TypeJuggling\TypeUtilInterface;

final class StringList implements ValueObjectListInterface
{
    use ValueObjectListTrait;

    protected static function getWantedType(string $fieldName): TypeUtilInterface
    {
        return new StringLiteral($fieldName);
    }
}
