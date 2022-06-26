<?php
namespace Apie\CompositeValueObjects\Fields;

use Apie\Core\Attributes\Optional;
use Apie\Core\Exceptions\InvalidTypeException;
use Apie\Core\ValueObjects\Interfaces\ValueObjectInterface;
use Apie\Core\ValueObjects\Utils;
use ReflectionIntersectionType;
use ReflectionProperty;
use UnitEnum;

final class FromProperty implements FieldInterface
{
    private ReflectionProperty $property;

    public function __construct(ReflectionProperty $property)
    {
        $this->property = $property;
        $property->setAccessible(true);
    }

    public function getTypehint(): string
    {
        return $this->property->getType()->getName();
    }

    public function isOptional(): bool
    {
        return $this->property->hasDefaultValue()
            || !empty($this->property->getAttributes(Optional::class))
            || $this->property->getType()->allowsNull();
    }

    public function fromNative(ValueObjectInterface $instance, mixed $value)
    {
        $type = $this->property->getType();
        if (null === $type || $type instanceof ReflectionIntersectionType) {
            throw new InvalidTypeException($type, 'ReflectionUnionType|ReflectionNamedType');
        }
        self::fillField($instance, Utils::toTypehint($type, $value));
    }

    public function fillField(ValueObjectInterface $instance, mixed $value)
    {
        $this->property->setValue($instance, $value);
    }

    public function fillMissingField(ValueObjectInterface $instance)
    {
        if (!$this->isOptional()) {
            $type = $this->property->getType();
            if (null === $type || $type instanceof ReflectionIntersectionType) {
                throw new InvalidTypeException($type, 'ReflectionUnionType|ReflectionNamedType');
            }
            throw new InvalidTypeException('(missing value)', $type->getName());
        }
        if (!empty($this->property->getAttributes(Optional::class))) {
            return;
        }
        $this->property->setValue($instance, $this->property->getDefaultValue());
    }

    public function isInitialized(ValueObjectInterface $instance): bool
    {
        return $this->property->isInitialized($instance);
    }

    public function getValue(ValueObjectInterface $instance): mixed
    {
        return $this->property->getValue($instance);
    }

    public function toNative(ValueObjectInterface $instance): null|array|string|int|float|bool|UnitEnum
    {
        $value = $this->getValue($instance);
        return Utils::toNative($value);
    }
}
