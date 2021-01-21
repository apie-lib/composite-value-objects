<?php


namespace Apie\CompositeValueObjects\Exceptions;

use Apie\Core\Exceptions\ApieException;
use phpDocumentor\Reflection\Type;

/**
 * Exception thrown by the the trait when a phpdoc is found that can not be mapped.
 */
class UnimplementedPhpDocBlockException extends ApieException
{
    public function __construct(string $fieldName, Type $type, ?\Throwable $previous = null)
    {
        $message = 'Type '
            . get_class($type)
            . ' found on field "'
            . $fieldName
            . '" is not implemented in apie/composite-value-objects';
        parent::__construct(
            500,
            $message,
            $previous
        );
    }
}