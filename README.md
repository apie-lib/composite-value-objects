# composite-value-objects

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/apie-lib/composite-value-objects/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/apie-lib/composite-value-objects/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/apie-lib/composite-value-objects/badges/build.png?b=main)](https://scrutinizer-ci.com/g/apie-lib/composite-value-objects/build-status/main)

This package is part of the [https://github.com/apie-lib](Apie) library.
The code is maintained in a monorepo, so PR's need to be sent to the [monorepo](https://github.com/apie-lib/apie-lib-monorepo/pulls)

## What does this package do?
Traits to build Apie-compatible value objects that are basically a composite of primitives/other value objects

## Documentation
This package contains everything to make composite value objects. What do I mean with that? They are basically
immutable objects that can be converted from/to an array with no identifier. For example a RangedDate value object is
a composite of a start and end date (and start date always needs to be before the end date). This package can use PHP7.4+
typed properties or read php docs to figure out the types.

### Setters
Since value objects need to be immutable this package will not add setters and also no constructor as it depends on a
value object what fields are required for construction. It will add a with method that allows you to make a new value object
with the changed value. Objects using this trait can only use other objects implementing ValueObjectInterface as we
can not garantuee that an object in the value object is immutable.

### Example
Here is a simple RangedDate value object using the Date value objects from
[apie/common-value-objects](https://github.com/apie-lib/composite-value-objects):

```php
<?php
class RangedDate implements ValueObjectInterface, ValueObjectCompareInterface
{
    use CompositeValueObjectTrait;

    /**
     * @var Date
     **/
    private $start;

    /**
     * @var Date
     **/
    private $end;

    public function __construct(Date $start, Date $end)
    {
        $this->start = $start;
        $this->end = $end;
        $this->validate();
    }

    protected function validate()
    {
        if ($this->end->toDateTime() < $this->start->toDateTime()) {
            throw new LogicException('End date should be after start date');
        }
    }

    public function getStart(): Date
    {
        return $this->start;
    }

    public function getEnd(): Date
    {
        return $this->end;
    }
}
```

Now we can use it as this:
```php
<?php
$christmas = new RangedDate(new Date('2020-12-25'), new Date('2020-12-26'));
$chistmas->toNative(); // returns ['start' => '2020-12-25', 'end' => '2020-12-26']
$instance = RangedDate::fromInstance(['start' => '2020-12-25', 'end' => '2020-12-26']); // same result

$happyHolidays = $christmas->with('end', '2020-12-31'); // a new value object with range 25-31 december.

// these all throw errors:
new RangedDate(new Date('2020-12-26'), new Date('2020-12-25'));
RangedDate::fromInstance(['start' => '2020-12-26', 'end' => '2020-12-25']);
RangedDate::fromInstance(['start' => 'this is not a date', 'end' => '2020-12-26']);
$christmas->with('start', '2021-01-01');
```

### PHP 7.4+ typehints
This library fully support properties with typehints. Remember that array typehint will always be mapped as primitive
arrays.

### Value object hashmaps
Hashmaps are arrays with key, value pairs. The keys can be any identifier. We made a specific ValueObjectHashmapTrait
to make it easier to be used in value objects.

We added 1 value objects using this trait: StringHashmap for a hashmap of values.

### Value object hashmaps
Lists are ordered arrays of a certain class. The keys can be any identifier. We made a specific ValueObjectListTrait
to make it easier to be used in value objects.

We added 3 value objects using this trait: IntegerList, UniqueStringList, StringTrait */'

Feel free how to read them.
