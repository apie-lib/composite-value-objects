<?php


namespace Apie\CompositeValueObjects;

use Apie\CompositeValueObjects\Exceptions\ObjectIsImmutableException;
use Apie\CompositeValueObjects\Utils\TypeUtils;
use ArrayIterator;
use ReflectionClass;
use ReflectionType;

trait ValueObjectHashmapTrait
{
    /**
     * @var array
     */
    private $list = [];

    abstract protected static function getWantedType(): ReflectionType;

    public static function fromNative($value)
    {
        $wantedType = self::getWantedType();
        $refl = new ReflectionClass(__CLASS__);
        $result = $refl->newInstanceWithoutConstructor();
        foreach ($value as $key => $item) {
            $type = TypeUtils::fromReflectionTypeToTypeUtilInterface(
                (string) $key,
                $wantedType
            );
            $result->list[$key] = $type->fromNative($item);
        }
        if (is_callable([$result, 'sanitizeValue'])) {
            $result->sanitizeValue();
        }

        return $result;
    }

    public function toNative()
    {
        $res = [];
        $wantedType = self::getWantedType();
        foreach ($this->list as $key => $item) {
            $type = TypeUtils::fromReflectionTypeToTypeUtilInterface(
                (string) $key,
                $wantedType
            );
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