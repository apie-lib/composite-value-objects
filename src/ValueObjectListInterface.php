<?php


namespace Apie\CompositeValueObjects;


use Apie\ValueObjects\ValueObjectInterface;
use ArrayAccess;
use Countable;
use IteratorAggregate;

interface ValueObjectListInterface extends ValueObjectInterface, ArrayAccess, IteratorAggregate, Countable
{
}