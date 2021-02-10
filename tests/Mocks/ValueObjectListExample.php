<?php

namespace Apie\Tests\CompositeValueObjects\Mocks;

use Apie\CompositeValueObjects\ValueObjectListInterface;
use Apie\CompositeValueObjects\ValueObjectListTrait;
use Apie\TypeJuggling\AnotherValueObject;
use Apie\TypeJuggling\TypeUtilInterface;

class ValueObjectListExample implements ValueObjectListInterface
{
    use ValueObjectListTrait;

    protected static function getWantedType(string $fieldName): TypeUtilInterface
    {
        return new AnotherValueObject($fieldName, ExampleWithMissingTypehint::class);
    }
}
