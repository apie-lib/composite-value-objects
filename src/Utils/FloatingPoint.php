<?php


namespace Apie\CompositeValueObjects\Utils;

use Apie\CompositeValueObjects\Exceptions\MissingValueException;
use Apie\ValueObjects\ValueObjectInterface;

class FloatingPoint implements TypeUtilInterface
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
            return (float) $input->toNative();
        }
        return (float) $input;
    }

    public function fromMissingValue()
    {
        throw new MissingValueException($this->fieldName);
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
                return true;
            case 'string':
                $filter = filter_var($input, FILTER_VALIDATE_FLOAT);
                return $filter !== false;
        }
        return false;
    }

    public function supportsToNative($input): bool
    {
        return gettype($input) === 'double' || gettype($input) === 'integer';
    }

    public function supportsFromNative($input): bool
    {
        return $this->supportsToNative($input);
    }

    public function __toString()
    {
        return 'float';
    }
}