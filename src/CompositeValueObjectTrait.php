<?php


namespace Apie\CompositeValueObjects;

use Apie\CompositeValueObjects\Exceptions\FieldMissingException;
use Apie\CompositeValueObjects\Utils\Compound;
use Apie\CompositeValueObjects\Utils\MixedTypehint;
use Apie\CompositeValueObjects\Utils\NullObject;
use Apie\CompositeValueObjects\Utils\TypeUtilInterface;
use Apie\CompositeValueObjects\Utils\TypeUtils;
use Apie\ValueObjects\ValueObjectInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use phpDocumentor\Reflection\DocBlockFactory;
use phpDocumentor\Reflection\Types\ContextFactory;

trait CompositeValueObjectTrait
{
    /**
     * @return TypeUtilInterface[]
     */
    private static function getFields(): array
    {
        $docBlockFactory = DocBlockFactory::createInstance();
        $contextFactory = new ContextFactory();
        $refl = new \ReflectionClass(static::class);
        $result = [];
        foreach ($refl->getProperties() as $property) {
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
        return $result;
    }

    public static function fromNative($value)
    {
        if ($value instanceof ValueObjectInterface) {
            $value = $value->toNative();
        }
        if (!is_array($value)) {
            // TODO exception
        }
        $refl = new \ReflectionClass(static::class);
        $object = $refl->newInstanceWithoutConstructor();
        foreach (static::getFields() as $fieldName => $fieldType) {
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