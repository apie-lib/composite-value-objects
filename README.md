<img src="https://raw.githubusercontent.com/apie-lib/apie-lib-monorepo/main/docs/apie-logo.svg" width="100px" align="left" />
<h1>composite-value-objects</h1>






 [![Latest Stable Version](http://poser.pugx.org/apie/composite-value-objects/v)](https://packagist.org/packages/apie/composite-value-objects) [![Total Downloads](http://poser.pugx.org/apie/composite-value-objects/downloads)](https://packagist.org/packages/apie/composite-value-objects) [![Latest Unstable Version](http://poser.pugx.org/apie/composite-value-objects/v/unstable)](https://packagist.org/packages/apie/composite-value-objects) [![License](http://poser.pugx.org/apie/composite-value-objects/license)](https://packagist.org/packages/apie/composite-value-objects) [![PHP Version Require](http://poser.pugx.org/apie/composite-value-objects/require/php)](https://packagist.org/packages/apie/composite-value-objects) [![Code coverage](https://raw.githubusercontent.com/apie-lib/composite-value-objects/main/coverage_badge.svg)](https://apie-lib.github.io/coverage/composite-value-objects/index.html)  

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
use Apie\Core\ValueObjects\CompositeValueObject;
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

Remember that the example has a constructor, but this is not required, but if you do forget to add one someone could misuser your
value object incorrectly by just calling new ValueObject() without constructor arguments. You could also make a private constructor
to force people to use fromNative() to create your object.

### Optional fields
By default all non-static fields are required and will throw an error if missing. To make a field optional you have 2 options.
You either add the Optional attribute to a property, or you give the property a default value.

Both examples below have the same result:

```php
<?php
use Apie\CommonValueObjects\Texts\DatabaseText;
use Apie\Core\ValueObjects\CompositeValueObject;

final class StreetAddress implements ValueObjectInterface
{
    use CompositeValueObject;

    private function __construct()
    {
        // this enforces other programmers to use fromNative
    }

    private DatabaseText $street;
    private DatabaseText $streetNumber;
    private ?DatabaseText $streetNumberSuffix = null;
}
```

```php
<?php
use Apie\CommonValueObjects\Texts\DatabaseText;
use Apie\Core\ValueObjects\CompositeValueObject;
use Apie\Core\Attributes\Optional;

final class StreetAddress implements ValueObjectInterface
{
    use CompositeValueObject;

    private function __construct()
    {
        // this enforces other programmers to use fromNative
    }

    private DatabaseText $street;
    private DatabaseText $streetNumber;

    #[Optional]
    private DatabaseText $streetNumberSuffix;
}
```
Remember that in PHP you will get errors if you try to read typehinted properties if they are not set. toNative() will not return
a value if they are not set.

### Validation
To add validation you can add a method validateState(). If the current state is invalid this method should throw an error.
It is being called by fromNative() if the method exists and should also be called with any custom constructor.

A good example is [time ranges](https://github.com/apie-lib/common-value-objects/blob/main/src/Ranges/DateTimeRange.php#L43) where the start time needs to be created before the end time.

Here we give an example of a combination of first and last name and the total length of both fields should not extend 255 characters.

```php
<?php
use Apie\Core\ValueObjects\CompositeValueObject;

final class FirstNameAndLastName implements ValueObjectInterface, Stringable
{
    use CompositeValueObject;

    private string $firstName;

    private string $lastName;

    public function __construct(private string $firstName, private string $lastName)
    {
        $this->validateState();
    }

    public function __toString(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    private function validateState(): void
    {
        if (strlen((string) $this) > 255) {
            throw new RuntimeException('Length of first name and last name should not exceed 255 characters');
        }
    }
}

### Union typehints
The composite value object trait supports union typehints. To avoid accidental casting and that the reflection API of PHP
will always return typehints in the same order(you don't have control over this) we check specific types first.

If the input is a string and string is a typehint it will pick string.

Otherwise the order of doing typecast is:
- objects+other types
- float
- int
- string

```php
<?php
use Apie\CommonValueObjects\Texts\DatabaseText;
use Apie\Core\ValueObjects\CompositeValueObject;
use Apie\Core\Attributes\Optional;

final class Example implements ValueObjectInterface
{
    use CompositeValueObject;

    private function __construct()
    {
        // this enforces other programmers to use fromNative
    }

    private string|int $value;

    public function getValue(): string|int
    {
        return $this->value;
    }
}
// getValue() returns '12' and is not casting to integer.
Example::fromNative(['value' => '12'])->getValue();
// getValue() returns 12 and is not casting to string.
Example::fromNative(['value' => 12])->getValue();
```
