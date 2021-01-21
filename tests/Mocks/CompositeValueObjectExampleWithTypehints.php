<?php


namespace Apie\Tests\CompositeValueObjects\Mocks;

use Apie\CompositeValueObjects\CompositeValueObjectTrait;
use Apie\CompositeValueObjects\Utils\Integer;
use Apie\CompositeValueObjects\Utils\TypeUtilInterface;
use Apie\CompositeValueObjects\Utils\TypeUtils;
use Apie\ValueObjects\ValueObjectCompareInterface;
use Apie\ValueObjects\ValueObjectInterface;
use phpDocumentor\Reflection\DocBlock\Tags\InvalidTag;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\Types\ContextFactory;

class CompositeValueObjectExampleWithTypehints implements ValueObjectInterface, ValueObjectCompareInterface
{
    use CompositeValueObjectTrait;

    private int $integer;

    private ?int $nullableInteger;

    private float $float;

    private ?float $nullableFloat;

    private ?CompositeValueObjectExampleWithTypehints $recursive;

    private function __construct() {
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