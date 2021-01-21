<?php


namespace Apie\CompositeValueObjects\Exceptions;


use Apie\Core\Exceptions\ApieException;

/**
 * Error thrown if a value is missing in the array.
 */
class MissingValueException extends ApieException
{
    public function __construct(string $fieldName)
    {
        parent::__construct(422, 'Value missing for field name "' . $fieldName . '"');
    }
}