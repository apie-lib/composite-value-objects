<?php


namespace Apie\CompositeValueObjects\Exceptions;

use Apie\Core\Exceptions\ApieException;
use Apie\ValueObjects\ValueObjectInterface;
use ReflectionClass;

class InvalidKeyException extends ApieException
{
    public function __construct(string $key, ?ValueObjectInterface $valueObject)
    {
        parent::__construct(
            422,
            sprintf(
                'Key "%s" is not valid for value object %s',
                $key,
                (new ReflectionClass($valueObject))->name
            )
        );
    }
}
