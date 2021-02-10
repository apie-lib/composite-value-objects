<?php


namespace Apie\Tests\CompositeValueObjects\Mocks;

use Apie\CompositeValueObjects\CompositeValueObjectTrait;
use Apie\ValueObjects\ValueObjectInterface;

class ExampleWithArrayTypehint implements ValueObjectInterface
{
    use CompositeValueObjectTrait;

    /**
     * @var array
     */
    private $mixedArray;
}
