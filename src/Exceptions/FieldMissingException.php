<?php


namespace Apie\CompositeValueObjects\Exceptions;

use Apie\Core\Exceptions\ApieException;
use ReflectionClass;

class FieldMissingException extends ApieException
{
    public function __construct(string $fieldName, $valueObject)
    {
        parent::__construct(
            500,
            sprintf(
                'Field "%s" does not exist on %s!',
                $fieldName,
                (new ReflectionClass($valueObject))->name
            )
        );
    }
}