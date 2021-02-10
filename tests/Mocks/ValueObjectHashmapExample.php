<?php

namespace Apie\Tests\CompositeValueObjects\Mocks;

use Apie\CompositeValueObjects\ValueObjectHashmapTrait;
use Apie\CompositeValueObjects\ValueObjectListInterface;
use Apie\TypeJuggling\AnotherValueObject;
use Apie\TypeJuggling\TypeUtilInterface;

class ValueObjectHashmapExample implements ValueObjectListInterface
{
    use ValueObjectHashmapTrait;

    protected static function getWantedType(string $fieldName): TypeUtilInterface
    {
        return new AnotherValueObject($fieldName, ExampleWithMissingTypehint::class);
    }
}
