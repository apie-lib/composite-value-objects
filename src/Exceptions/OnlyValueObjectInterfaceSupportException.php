<?php


namespace Apie\CompositeValueObjects\Exceptions;

use Apie\Core\Exceptions\ApieException;

/**
 * Exception thrown if a wrong type is sent to fromNative that is not supported, for
 * example resources or any arbitrary class.
 */
class OnlyValueObjectInterfaceSupportException extends ApieException
{
    public function __construct(string $fieldName, ?string $className) {
        $message = 'Typehint object on field "' . $fieldName . '" is not supported';
        if ($className !== null) {
            $message = 'Class ' . $className . ' found on field "' . $fieldName . '" is not implementing ValueObjectInterface and is not supported';
        }
        parent::__construct(422, $message);
    }
}