<?php
namespace Apie\CompositeValueObjects\Fields;

use Apie\Core\ValueObjects\Interfaces\ValueObjectInterface;
use UnitEnum;

interface FieldInterface
{
    public function fillField(ValueObjectInterface $instance, mixed $value);

    public function fillMissingField(ValueObjectInterface $instance);

    public function getValue(ValueObjectInterface $instance): mixed;

    public function toNative(ValueObjectInterface $instance): array|string|int|float|bool|UnitEnum|null;

    public function isInitialized(ValueObjectInterface $instance): bool;

    public function isOptional(): bool;

    public function getTypehint(): string;
}
