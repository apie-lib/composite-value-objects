<?php


namespace Apie\CompositeValueObjects;

use Apie\CompositeValueObjects\Exceptions\ObjectIsImmutableException;
use Apie\TypeJuggling\TypeUtilInterface;
use Apie\ValueObjects\Exceptions\InvalidValueForValueObjectException;
use ArrayIterator;
use ReflectionClass;

trait ValueObjectListTrait
{
    /**
     * @var array
     */
    private $list = [];

    abstract protected static function getWantedType(string $key): TypeUtilInterface;

    public static function fromNative($value)
    {
        $counter = 0;
        $refl = new ReflectionClass(static::class);
        $result = $refl->newInstanceWithoutConstructor();
        if (!is_iterable($value)) {
            throw new InvalidValueForValueObjectException($value, static::class);
        }
        foreach ($value as $item) {
            $type = static::getWantedType((string) $counter);
            $result->list[$counter] = $type->fromNative($item);
            $counter++;
        }
        if (is_callable([$result, 'sanitizeValue'])) {
            $result->sanitizeValue();
        }

        return $result;
    }

    public function toNative()
    {
        $res = [];
        foreach ($this->list as $key => $item) {
            $type = static::getWantedType((string) $key);
            $res[$key] = $type->toNative($item);
        }
        return $res;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->list);
    }

    public function offsetExists($offset)
    {
        return isset($this->list[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->list[$offset];
    }

    public function offsetSet($offset, $value)
    {
        throw new ObjectIsImmutableException($this);
    }

    public function offsetUnset($offset)
    {
        throw new ObjectIsImmutableException($this);
    }

    public function count()
    {
        return count($this->list);
    }
}
