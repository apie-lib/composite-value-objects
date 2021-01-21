<?php

namespace Apie\Tests\CompositeValueObjects\Utils;

use Apie\CompositeValueObjects\Exceptions\UnimplementedPhpDocBlockException;
use Apie\CompositeValueObjects\Factory\ReflectionTypeFactory;
use Apie\CompositeValueObjects\Utils\Compound;
use Apie\CompositeValueObjects\Utils\FloatingPoint;
use Apie\CompositeValueObjects\Utils\Integer;
use Apie\CompositeValueObjects\Utils\NullObject;
use Apie\CompositeValueObjects\Utils\StringLiteral;
use Apie\CompositeValueObjects\Utils\TypeUtilInterface;
use Apie\CompositeValueObjects\Utils\TypeUtils;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Resource_;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;
use ReflectionType;

class TypeUtilsTest extends TestCase
{
    /**
     * @dataProvider objectProvider
     */
    public function testFromObjectToTypeUtilInterface(TypeUtilInterface $expected, $input)
    {
        $this->assertEquals($expected, TypeUtils::fromObjectToTypeUtilInterface('fieldName', $input));
    }

    /**
     * @test
     */
    public function type_utils_throw_exception_on_invalid_object()
    {
        $this->expectException(UnimplementedPhpDocBlockException::class);
        $resource = fopen(__FILE__, 'r');
        fclose($resource);
        TypeUtils::fromObjectToTypeUtilInterface('fieldName', $resource);
    }

    public function objectProvider()
    {
        yield [new NullObject(), null];
        yield [new Integer('fieldName'), 12];
        yield [new FloatingPoint('fieldName'), 12.5];
    }

    /**
     * @dataProvider reflectionTypeProvider
     */
    public function testFromReflectionTypeToTypeUtilInterface(TypeUtilInterface $expected, ReflectionType $input)
    {
        $this->assertEquals($expected, TypeUtils::fromReflectionTypeToTypeUtilInterface('fieldName', $input));
    }

    public function reflectionTypeProvider()
    {
        yield [new Integer('fieldName'), ReflectionTypeFactory::createInt(false)];
        yield [new Compound('fieldName', new Integer('fieldName'), new NullObject()), ReflectionTypeFactory::createInt(true)];
        yield [new StringLiteral('fieldName'), ReflectionTypeFactory::createString(false)];
        yield [new Compound('fieldName', new StringLiteral('fieldName'), new NullObject()), ReflectionTypeFactory::createString(true)];

    }

    /**
     * @dataProvider typeProvider
     */
    public function testFromTypeToTypeUtilInterface(TypeUtilInterface $expected, Type $input)
    {
        $this->assertEquals($expected, TypeUtils::fromTypeToTypeUtilInterface('fieldName', $input));
    }

    /**
     * @test
     */
    public function type_utils_throw_exception_on_unsupported_docblock()
    {
        $this->expectException(UnimplementedPhpDocBlockException::class);
        TypeUtils::fromTypeToTypeUtilInterface('fieldName', new Resource_());
    }

    public function typeProvider()
    {
        yield [new StringLiteral('fieldName'), new String_()];
        yield [new Integer('fieldName'), new \phpDocumentor\Reflection\Types\Integer()];
    }
}
