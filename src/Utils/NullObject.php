<?php


namespace Apie\CompositeValueObjects\Utils;


use Apie\ValueObjects\ValueObjectInterface;

class NullObject implements TypeUtilInterface
{
    public function fromNative($input)
    {
        return null;
    }

    public function toNative($input)
    {
        return null;
    }

    public function fromMissingValue()
    {
        return null;
    }

    public function supports($input): bool
    {
        if ($input instanceof ValueObjectInterface && $input->toNative() === null) {
            return true;
        }
        return $input === null;
    }

    public function supportsToNative($input): bool
    {
        return $input === null;
    }

    public function supportsFromNative($input): bool
    {
        return $input === null;
    }

    public function __toString()
    {
        return 'null';
    }
}