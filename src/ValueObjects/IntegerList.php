<?php


namespace Apie\CompositeValueObjects\ValueObjects;

use Apie\CompositeValueObjects\ValueObjectListInterface;
use Apie\CompositeValueObjects\ValueObjectListTrait;
use Apie\TypeJuggling\Integer;
use Apie\TypeJuggling\TypeUtilInterface;

final class IntegerList implements ValueObjectListInterface
{
    use ValueObjectListTrait;

    protected static function getWantedType(string $fieldName): TypeUtilInterface
    {
        return new Integer($fieldName);
    }
}
