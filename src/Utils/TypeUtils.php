<?php


namespace Apie\CompositeValueObjects\Utils;

use Apie\CompositeValueObjects\Exceptions\UnimplementedPhpDocBlockException;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types as Types;

class TypeUtils
{
    private function __construct()
    {
    }

    public static function fromObjectToTypeUtilInterface(string $fieldName, $object): TypeUtilInterface
    {
        if ($object === null) {
            return new NullObject();
        }
        switch (gettype($object)) {
            case 'boolean':
                return new Boolean($fieldName);
            case 'integer':
                return new Integer($fieldName);
            case 'double':
                return new FloatingPoint($fieldName);
            case 'string':
                return new StringLiteral($fieldName);
            case 'array':
                return new PrimitiveArray($fieldName);
            case 'object':
                return new AnotherValueObject($fieldName, get_class($object));
        }
        throw new UnimplementedPhpDocBlockException($fieldName, new Types\Void_());
    }

    public static function fromReflectionTypeToTypeUtilInterface(string $fieldName, \ReflectionType $reflectionType): TypeUtilInterface
    {
        $class = $reflectionType->getName();
        switch ($class) {
            case 'bool':
                $object = new Boolean($fieldName);
                break;
            case 'int':
                $object = new Integer($fieldName);
                break;
            case 'string':
                $object = new StringLiteral($fieldName);
                break;
            case 'float':
                $object = new FloatingPoint($fieldName);
                break;
            case 'array':
                $object = new PrimitiveArray($fieldName);
                break;
            default:
                $object = new AnotherValueObject($fieldName, $class);
        }
        if ($reflectionType->allowsNull()) {
            return new Compound($fieldName, $object, new NullObject());
        }
        return $object;
    }

    public static function fromTypeToTypeUtilInterface(string $fieldName, Type $type): TypeUtilInterface
    {
        if ($type instanceof Types\Boolean) {
            return new Boolean($fieldName);
        }
        if ($type instanceof Types\Float_) {
            return new FloatingPoint($fieldName);
        }
        if ($type instanceof Types\Array_) {
            return new PrimitiveArray($fieldName);
        }
        if ($type instanceof Types\Object_) {
            $className = $type->getFqsen();
            return new AnotherValueObject($fieldName, $className);
        }
        if ($type instanceof Types\Integer) {
            return new Integer($fieldName);
        }
        if ($type instanceof Types\String_) {
            return new StringLiteral($fieldName);
        }
        if ($type instanceof Types\Mixed_) {
            return new MixedTypehint($fieldName);
        }
        if ($type instanceof Types\Null_) {
            return new NullObject();
        }
        if ($type instanceof Types\Compound) {
            $compoundTypes = [];
            foreach ($type as $compoundItemType) {
                $compoundTypes[] = self::fromTypeToTypeUtilInterface($fieldName, $compoundItemType);
            }
            return new Compound($fieldName, ...$compoundTypes);
        }
        throw new UnimplementedPhpDocBlockException($fieldName, $type);
    }
}