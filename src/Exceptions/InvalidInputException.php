<?php


namespace Apie\CompositeValueObjects\Exceptions;

use Apie\CompositeValueObjects\Utils\TypeUtilInterface;
use Apie\Core\Exceptions\ApieException;

/**
 * Thrown when a type could not be converted into the native type.
 */
class InvalidInputException extends ApieException
{
    public function __construct(string $fieldName, TypeUtilInterface $typeUtil, $input)
    {
        $message = 'Wrong input for field "' . $fieldName . '" expect '. $typeUtil . ' got ' . get_debug_type($input);
        parent::__construct(422, $message);
    }
}