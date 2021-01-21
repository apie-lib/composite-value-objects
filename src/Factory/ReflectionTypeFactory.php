<?php


namespace Apie\CompositeValueObjects\Factory;

use ReflectionClass;
use ReflectionType;

final class ReflectionTypeFactory
{
    private static $typeMapping = [];

    private function __construct()
    {
    }

    private static function getType(string $methodName): ReflectionType
    {
        if (isset(self::$typeMapping[$methodName])) {
            return self::$typeMapping[$methodName];
        }
        $code = '
            $call = function (' . $methodName . ' $argument) {};
            $refl = new ReflectionFunction($call);
            return $refl->getParameters()[0]->getType();
        ';
        return self::$typeMapping[$methodName] = eval($code);
    }

    public static function createInt(bool $nullable): ReflectionType
    {
        return self::getType($nullable ? '?int' : 'int');
    }

    public static function createString(bool $nullable): ReflectionType
    {
        return self::getType($nullable ? '?string' : 'string');
    }

    public static function createForClass(string $className): ReflectionType
    {
        return self::getType('\\' . $className);
    }
}