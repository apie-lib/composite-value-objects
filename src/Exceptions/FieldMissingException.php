<?php


namespace Apie\CompositeValueObjects\Exceptions;

use Apie\Core\Exceptions\ApieException;
use Apie\Core\Exceptions\FieldNameAwareInterface;
use ReflectionClass;

class FieldMissingException extends ApieException implements FieldNameAwareInterface
{
    /**
     * @var string
     */
    private $fieldName;

    public function __construct(string $fieldName, $valueObject)
    {
        $this->fieldName = $fieldName;
        parent::__construct(
            500,
            sprintf(
                'Field "%s" does not exist on %s!',
                $fieldName,
                (new ReflectionClass($valueObject))->name
            )
        );
    }

    /**
     * @return string
     */
    public function getFieldName(): string
    {
        return $this->fieldName;
    }
}
