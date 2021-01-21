<?php


namespace Apie\CompositeValueObjects\Exceptions;


use Apie\Core\Exceptions\ApieException;

/**
 * Exception thrown if some code tries to modify a value object.
 */
class ObjectIsImmutableException extends ApieException
{
    public function __construct($object)
    {
        parent::__construct(400, 'Object '. get_debug_type($object) . ' is immutable!');
    }
}