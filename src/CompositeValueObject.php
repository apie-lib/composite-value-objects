<?php
namespace Apie\CompositeValueObjects;

use Apie\CompositeValueObjects\Fields\FieldInterface;
use Apie\CompositeValueObjects\Fields\FromProperty;
use Apie\Core\Attributes\Internal;
use Apie\Core\ValueObjects\Utils;
use ReflectionClass;

/**
 * Use this trait to make a value object consisting of multiple properties.
 */
trait CompositeValueObject
{
    /**
     * @var FieldInterface[]
     */
    private static array $fields;

    public static function getFields(): array
    {
        if (!isset(self::$fields)) {
            $fields = [];
            $refl = new ReflectionClass(__CLASS__);
            foreach ($refl->getProperties() as $property) {
                if ($property->isStatic()) {
                    continue;
                }
                if (!empty($property->getAttributes(Internal::class))) {
                    continue;
                }
                $fields[$property->getName()] = new FromProperty($property);
            }
            self::$fields = $fields;
        }

        return self::$fields;
    }

    public static function fromNative(mixed $input): self
    {
        $input = Utils::toArray($input);
        $refl = new ReflectionClass(__CLASS__);
        $instance = $refl->newInstanceWithoutConstructor();
        foreach (self::getFields() as $fieldName => $field) {
            if (array_key_exists($fieldName, $input)) {
                $field->fromNative($instance, $input[$fieldName]);
            } else {
                $field->fillMissingField($instance);
            }
        }
        return $instance;
    }
    public function toNative(): array
    {
        $result = [];
        foreach (self::getFields() as $fieldName => $field) {
            $result[$fieldName] = $field->toNative($this);
        }
        return $result;
    }
}