<?php


namespace Apie\CompositeValueObjects;

use Apie\CompositeValueObjects\Exceptions\FieldMissingException;
use Apie\CompositeValueObjects\Exceptions\IgnoredKeysException;
use Apie\TypeJuggling\Compound;
use Apie\TypeJuggling\MixedTypehint;
use Apie\TypeJuggling\NullObject;
use Apie\TypeJuggling\TypeUtilInterface;
use Apie\TypeJuggling\TypeUtils;
use Apie\ValueObjects\Exceptions\InvalidValueForValueObjectException;
use Apie\ValueObjects\ValueObjectInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\Types\ContextFactory;

trait CompositeValueObjectTrait
{
    /**
     * @var TypeUtilInterface[]
     */
    private static $fieldDefinitions;

    /**
     * @return TypeUtilInterface[]
     */
    private static function getFields(): array
    {
        if (self::$fieldDefinitions) {
            return self::$fieldDefinitions;
        }
        $docBlockFactory = DocBlockFactory::createInstance();
        $contextFactory = new ContextFactory();
        $refl = new \ReflectionClass(static::class);
        $result = [];
        foreach ($refl->getProperties() as $property) {
            if ($property->isStatic()) {
                continue;
            }
            if (PHP_VERSION_ID >= 70400) {
                $type = $property->getType();
                if ($type) {
                    $result[$property->name] = TypeUtils::fromReflectionTypeToTypeUtilInterface($property->name, $type);
                    continue;
                }
            }
            if ($property->getDocComment()) {
                $docBlock = $docBlockFactory->create($property, $contextFactory->createFromReflector($refl));
                foreach ($docBlock->getTagsByName('var') as $var) {
                    if ($var instanceof Var_) {
                        $docType = $var->getType();
                        $result[$property->name] = TypeUtils::fromTypeToTypeUtilInterface($property->name, $docType);
                    }
                }
            } else {
                $result[$property->name] = new Compound($property->name, new MixedTypehint($property->name), new NullObject());
            }
        }
        return self::$fieldDefinitions = $result;
    }

    public static function supportsFromNative($value): bool
    {
        if ($value instanceof ValueObjectInterface) {
            $value = $value->toNative();
        }
        if (!is_array($value)) {
            return false;
        }
        $fields = static::getFields();
        $ignored = array_diff_key($value, $fields);
        return empty($ignored);
    }

    public static function fromNative($value)
    {
        if ($value instanceof ValueObjectInterface) {
            $value = $value->toNative();
        }
        if (!is_array($value)) {
            throw new InvalidValueForValueObjectException($value, static::class);
        }
        $refl = new \ReflectionClass(static::class);
        $object = $refl->newInstanceWithoutConstructor();
        $fields = static::getFields();
        $ignored = array_diff_key($value, $fields);
        if (!empty($ignored)) {
            throw new IgnoredKeysException(array_keys($ignored), array_keys($fields));
        }
        foreach ($fields as $fieldName => $fieldType) {
            if (array_key_exists($fieldName, $value)) {
                $object->$fieldName = $fieldType->fromNative($value[$fieldName]);
            } else {
                $object->$fieldName = $fieldType->fromMissingValue();
            }
        }

        if (is_callable([$object, 'validateProperties'])) {
            $object->validateProperties();
        }

        return $object;
    }

    public function toNative()
    {
        $result = [];
        foreach (static::getFields() as $fieldName => $fieldType) {
            $result[$fieldName] = $fieldType->toNative($this->$fieldName);
        }
        return $result;
    }

    public function with(string $fieldName, $value): self
    {
        $fields = static::getFields();
        if (!isset($fields[$fieldName])) {
            throw new FieldMissingException($fieldName, $this);
        }
        $object = clone $this;
        $object->$fieldName = $fields[$fieldName]->fromNative($value);
        if (is_callable([$object, 'validateProperties'])) {
            $object->validateProperties();
        }
        return $object;
    }
}
