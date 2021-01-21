<?php


namespace Apie\CompositeValueObjects\Utils;


use Apie\CompositeValueObjects\Exceptions\MissingValueException;
use Apie\ValueObjects\ValueObjectInterface;

class StringLiteral implements TypeUtilInterface
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

    public function fromMissingValue()
    {
        throw new MissingValueException($this->fieldName);
    }

    public function toNative($input)
    {
        if ($input instanceof ValueObjectInterface) {
            return $this->toNative($input->toNative());
        }
        return is_array($input) ? 'array' : (string) $input;
    }

    public function supports($input): bool
    {
        if ($input instanceof ValueObjectInterface && $this->supports($input->toNative())) {
            return true;
        }
        switch (gettype($input)) {
            case 'boolean':
            case 'integer':
            case 'double':
            case 'string':
                return true;
        }
        return false;
    }

    public function supportsToNative($input): bool
    {
        return gettype($input) === 'string';
    }

    public function supportsFromNative($input): bool
    {
        return $this->supportsToNative($input);
    }

    public function __toString()
    {
        return 'string';
    }
}