<?php


namespace Apie\CompositeValueObjects\Utils;

use Apie\CompositeValueObjects\Exceptions\InvalidInputException;
use Apie\CompositeValueObjects\Exceptions\MissingValueException;

class Compound implements TypeUtilInterface
{
    /**
     * @var TypeUtilInterface[]
     */
    private $subTypes;
    /**
     * @var string
     */
    private $fieldName;

    public function __construct(string $fieldName, TypeUtilInterface... $subTypes)
    {
        $this->fieldName = $fieldName;
        $this->subTypes = $subTypes;
    }

    public function fromNative($input)
    {
        foreach ($this->subTypes as $subType) {
            if ($subType->supportsFromNative($input)) {
                return $subType->fromNative($input);
            }
        }
        foreach ($this->subTypes as $subType) {
            if ($subType->supports($input)) {
                return $subType->fromNative($input);
            }
        }
        throw new InvalidInputException($this->fieldName, $this, $input);
    }

    public function toNative($input)
    {
        foreach ($this->subTypes as $subType) {
            if ($subType->supportsToNative($input)) {
                return $subType->toNative($input);
            }
        }
        foreach ($this->subTypes as $subType) {
            if ($subType->supports($input)) {
                return $subType->toNative($input);
            }
        }
        throw new InvalidInputException($this->fieldName, $this, $input);
    }

    public function fromMissingValue()
    {
        foreach ($this->subTypes as $subType) {
            try {
                return $subType->fromMissingValue();
            } catch (\Exception $e) {
            }
        }
        throw new MissingValueException($this->fieldName);
    }

    public function supports($input): bool
    {
        foreach ($this->subTypes as $subType) {
            if ($subType->supports($input)) {
                return true;
            }
        }
        return false;
    }

    public function supportsFromNative($input): bool
    {
        foreach ($this->subTypes as $subType) {
            if ($subType->supportsFromNative($input)) {
                return true;
            }
        }
        return false;
    }

    public function supportsToNative($input): bool
    {
        foreach ($this->subTypes as $subType) {
            if ($subType->supportsToNative($input)) {
                return true;
            }
        }
        return false;
    }

    public function __toString()
    {
        return '(' . join('|', $this->subTypes) . ')';
    }
}