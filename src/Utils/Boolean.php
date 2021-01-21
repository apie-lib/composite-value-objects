<?php


namespace Apie\CompositeValueObjects\Utils;


use Apie\CompositeValueObjects\Exceptions\MissingValueException;
use Apie\ValueObjects\ValueObjectInterface;

class Boolean implements TypeUtilInterface
{
    /**
     * @var string
     */
    private $fieldName;

    public function __construct(string $fieldName)
    {
        $this->fieldName = $fieldName;
    }

    public function fromNative($input)
    {
        return $this->toNative($input);
    }

    public function toNative($input)
    {
        if ($input instanceof ValueObjectInterface) {
            return !! $input->toNative();
        }
        return !! $input;
    }

    public function fromMissingValue()
    {
        throw new MissingValueException($this->fieldName);
    }

    public function supports($input): bool
    {
        if ($input instanceof ValueObjectInterface) {
            return $this->supportsFromNative($input->toNative());
        }
        return $this->supportsFromNative($input);
    }

    public function supportsToNative($input): bool
    {
        return gettype($input) === 'boolean';
    }

    public function supportsFromNative($input): bool
    {
        return $this->supportsToNative($input);
    }

    public function __toString()
    {
        return 'bool';
    }
}