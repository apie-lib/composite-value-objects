<?php


namespace Apie\Tests\CompositeValueObjects\Mocks;

use Apie\CompositeValueObjects\CompositeValueObjectTrait;
use Apie\ValueObjects\ValueObjectInterface;

class ExampleWithMissingTypehint implements ValueObjectInterface
{
    use CompositeValueObjectTrait;

    private $noTypehint;

    public function getNoTypehint()
    {
        return $this->noTypehint;
    }

    public function setNoTypehint($noTypehint): void
    {
        $this->noTypehint = $noTypehint;
    }
}
