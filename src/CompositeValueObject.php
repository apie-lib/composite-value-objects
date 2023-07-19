<?php
namespace Apie\CompositeValueObjects\ValueObjects;

use Apie\Core\ValueObjects\CompositeValueObject as ValueObjectsCompositeValueObject;

/**
 * Use this trait to make a value object consisting of multiple properties.
 *
 * @deprecated use Apie\Core\ValueObjects\CompositeValueObject instead
 */
trait CompositeValueObject
{
    use ValueObjectsCompositeValueObject;
}
