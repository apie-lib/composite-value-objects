<?php


namespace Apie\Tests\CompositeValueObjects\Mocks;

use Apie\CompositeValueObjects\CompositeValueObjectTrait;
use Apie\ValueObjects\ValueObjectCompareInterface;
use Apie\ValueObjects\ValueObjectInterface;

class ExampleWithMixedTypehint implements ValueObjectInterface, ValueObjectCompareInterface
{
    use CompositeValueObjectTrait;

    /**
     * @var mixed
     */
    private $mixed;

    /**
     * @param mixed $mixed
     */
    public function __construct($mixed)
    {
        $this->mixed = $mixed;
    }

    /**
     * @return mixed
     */
    public function getMixed()
    {
        return $this->mixed;
    }
}