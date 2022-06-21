# composite-value-objects

 [![Latest Stable Version](http://poser.pugx.org/apie/composite-value-objects/v)](https://packagist.org/packages/apie/composite-value-objects) [![Total Downloads](http://poser.pugx.org/apie/composite-value-objects/downloads)](https://packagist.org/packages/apie/composite-value-objects) [![Latest Unstable Version](http://poser.pugx.org/apie/composite-value-objects/v/unstable)](https://packagist.org/packages/apie/composite-value-objects) [![License](http://poser.pugx.org/apie/composite-value-objects/license)](https://packagist.org/packages/apie/composite-value-objects) [![PHP Version Require](http://poser.pugx.org/apie/composite-value-objects/require/php)](https://packagist.org/packages/apie/composite-value-objects) 

[![PHP Composer](https://github.com/apie-lib/composite-value-objects/actions/workflows/php.yml/badge.svg?event=push)](https://github.com/apie-lib/composite-value-objects/actions/workflows/php.yml)

This package is part of the [Apie](https://github.com/apie-lib) library.
The code is maintained in a monorepo, so PR's need to be sent to the [monorepo](https://github.com/apie-lib/apie-lib-monorepo/pulls)

## Documentation
Composite value objects is mainly a trait that can be used inside value objects for value objects that are a composite of value objects or primitives. For example a range value object is often best used as a value object itself because the start and the end of the range should be in a restricted range..

### Usage
All you need to do is make an object with the ValueObjectInterface and the CompositeValueObject trait. Then all you need are properties and fromNative and toNative will change accordingly.

For example:
```php
<?php
use Apie\CommonValueObjects\Texts\DatabaseText;
use Apie\CompositeValueObjects\CompositeValueObject;
use Stringable;

final class StreetAddress implements ValueObjectInterface, Stringable
{
    use CompositeValueObject;

    public function __construct(private DatabaseText $street, private DatabaseText $streetNumber)
    {}

    public function __toString(): string
    {
        return $this->street . ' ' . $this->streetNumber;
    }
}

// creates a StreetAddress value object from an array.
$address = StreetAddress::fromNative([
    'street' => 'Example Street',
    'streetNumber' => 42
]);
// $addressDisplay = 'Example Street 42';
$addressDisplay = (string) $address;

// return array again
$address->toNative();

// throws error for missing street number
$address = StreetAddress::fromNative([
    'street' => 'Example Street'
]);

```

Remember that the example has a constructor, but this is not required, but if you do forget to add one someone could use your
value object incorrectly by just calling new ValueObject() without constructor arguments. You could also make a private constructor
if you want people to make your value object with the fromNative method.

### Optional fields
By default all non-static fields are required and will throw an error if missing. To make a field optional you have 2 options.
You either add the Optional attribute to a property, or you give the property a default value.

Both examples below have the same result:

```php
<?php
use Apie\CommonValueObjects\Texts\DatabaseText;
use Apie\CompositeValueObjects\CompositeValueObject;

final class StreetAddress implements ValueObjectInterface
{
    use CompositeValueObject;

    private function __construct()
    {
        // this enforces other programers to use fromNative
    }

    private DatabaseText $street;
    private DatabaseText $streetNumber;
    private ?DatabaseText $streetNumberSuffix = null;
}
```

```php
<?php
use Apie\CommonValueObjects\Texts\DatabaseText;
use Apie\CompositeValueObjects\CompositeValueObject;
use Apie\Core\Attributes\Optional;

final class StreetAddress implements ValueObjectInterface
{
    use CompositeValueObject;

    private function __construct()
    {
        // this enforces other programers to use fromNative
    }

    private DatabaseText $street;
    private DatabaseText $streetNumber;

    #[Optional]
    private DatabaseText $streetNumberSuffix;
}
```


### Union typehints
The composite value object trait supports union typehints. To avoid accidental casting and that the reflection API of PHP
will always return typehints in the same order we check specific types first.

The order is objects+other types, floating point, number, and strings as lowest priority.

```php
<?php
use Apie\CommonValueObjects\Texts\DatabaseText;
use Apie\CompositeValueObjects\CompositeValueObject;
use Apie\Core\Attributes\Optional;

final class Example implements ValueObjectInterface
{
    use CompositeValueObject;

    private function __construct()
    {
        // this enforces other programers to use fromNative
    }

    private string|int $value;

    public function getValue(): string|int
    {
        return $this->value;
    }
}
// getValue() returns 12 as '12' can be cast to a integer.
Example::fromNative(['value' => '12'])->getValue();
```
