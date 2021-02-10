<?php


namespace Apie\CompositeValueObjects\Exceptions;

use Apie\Core\Exceptions\ApieException;

class IgnoredKeysException extends ApieException
{
    public function __construct(array $keys, array $knownKeys)
    {
        parent::__construct(
            424,
            sprintf(
                'The array contains keys that are not known: %s\nKnown keys: %s',
                trim(json_encode($keys), '[]'),
                trim(json_encode($knownKeys), '[]')
            )
        );
    }
}
