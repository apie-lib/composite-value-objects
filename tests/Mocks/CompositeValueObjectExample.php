<?php


namespace Apie\Tests\CompositeValueObjects\Mocks;

use Apie\CompositeValueObjects\CompositeValueObjectTrait;
use Apie\ValueObjects\ValueObjectInterface;

class CompositeValueObjectExample implements ValueObjectInterface
{
    use CompositeValueObjectTrait;

    /**
     * @var int
     */
    private $integer;

    /**
     * @var int|null
     */
    private $nullableInteger;

    /**
     * @var float
     */
    private $float;

    /**
     * @var float|null
     */
    private $nullableFloat;

    /**
     * @var CompositeValueObjectExample|null
     */
    private $recursive;

    private function __construct()
    {
    }

    /**
     * @return int
     */
    public function getInteger(): int
    {
        return $this->integer;
    }

    /**
     * @return int|null
     */
    public function getNullableInteger(): ?int
    {
        return $this->nullableInteger;
    }

    /**
     * @return float
     */
    public function getFloat(): float
    {
        return $this->float;
    }

    /**
     * @return float|null
     */
    public function getNullableFloat(): ?float
    {
        return $this->nullableFloat;
    }
}
