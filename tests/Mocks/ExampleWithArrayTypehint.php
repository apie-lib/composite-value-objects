<?php


namespace Apie\Tests\CompositeValueObjects\Mocks;


use Apie\CompositeValueObjects\CompositeValueObjectTrait;
use Apie\ValueObjects\ValueObjectCompareInterface;
use Apie\ValueObjects\ValueObjectInterface;

class ExampleWithArrayTypehint implements ValueObjectInterface, ValueObjectCompareInterface
{
    use CompositeValueObjectTrait;

    /**
     * @var array
     */
    private $mixedArray;
}