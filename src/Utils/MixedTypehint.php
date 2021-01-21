<?php


namespace Apie\CompositeValueObjects\Utils;

use Apie\CompositeValueObjects\Exceptions\MissingValueException;
use Apie\ValueObjects\ValueObjectInterface;

class MixedTypehint extends Compound
{
    private $fieldName;

    public function __construct(string $fieldName)
    {
        $this->fieldName = $fieldName;
        parent::__construct(
            $fieldName,
            new Boolean($fieldName),
            new FloatingPoint($fieldName),
            new Integer($fieldName),
            new StringLiteral($fieldName),
            new PrimitiveArray($fieldName),
            new NullObject()
        );
    }

    public function fromMissingValue()
    {
        throw new MissingValueException($this->fieldName);
    }

    public function supports($input): bool
    {
        return ($input instanceof ValueObjectInterface) || parent::supports($input);
    }

    public function supportsFromNative($input): bool
    {
        return ($input instanceof ValueObjectInterface) || parent::supportsFromNative($input);
    }

    public function supportsToNative($input): bool
    {
        return ($input instanceof ValueObjectInterface) || parent::supportsToNative($input);
    }

    public function fromNative($input)
    {
        if ($input instanceof ValueObjectInterface) {
            return $input;
        }
        return parent::fromNative($input);
    }

    public function toNative($input)
    {
        if ($input instanceof ValueObjectInterface) {
            return $input->toNative();
        }
        return parent::toNative($input);
    }

    public function __toString()
    {
        return 'mixed';
    }
}