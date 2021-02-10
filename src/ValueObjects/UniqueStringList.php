<?php


namespace Apie\CompositeValueObjects\ValueObjects;

use Apie\CompositeValueObjects\ValueObjectListInterface;
use Apie\CompositeValueObjects\ValueObjectListTrait;
use Apie\TypeJuggling\StringLiteral;
use Apie\TypeJuggling\TypeUtilInterface;

final class UniqueStringList implements ValueObjectListInterface
{
    use ValueObjectListTrait;

    protected function sanitizeValue()
    {
        $this->list = array_values(array_unique($this->list));
    }

    protected static function getWantedType(string $fieldName): TypeUtilInterface
    {
        return new StringLiteral($fieldName);
    }
}
