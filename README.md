# Type Guard

[![codecov](https://codecov.io/gh/pl-github/php-TYPE-GUARD/graph/badge.svg?token=IYNVCXQS8A)](https://codecov.io/gh/pl-github/php-TYPE-GUARD)

A PHP library to ensure correctness of types providing a readable interface.

## Installation

```shell
$ composer require plook/type-guard
```

## Example

```php
use function Plook\TypeGuard\asBool;
use function Plook\TypeGuard\asDateTimeImmutable;
use function Plook\TypeGuard\asFloat;
use function Plook\TypeGuard\asInt;
use function Plook\TypeGuard\asString;
use function Plook\TypeGuard\notNull;

$row = $this->fetchProjectRow(123);

$project = new Project(
     notNull(asInt($row['id'])),
     notNull(asString($row['name'])),
     notNull(asDateTimeImmutable($row['createdAt'])),
     notNull(asBool($row['is_assigned'])),
     asDateTimeImmutable($row['closedAt']),
     asFloat($row['rating']),
);
```

## Provided helper functions

### Ensure Types
* `asBool($value)` Converts input value to a boolean, but passes `null`.
* `asFloat($value)` Converts input value to a float, but passes `null`.
* `asInt($value)` Converts input value to a int, but passes `null`.
* `asDateTimeImmutable($value)` Converts input value to a `DateTimeImmutable` object, but passes `null`.
* `asDateTimeString($value)` Converts input value to a date string including the timezone, but passes `null`.
* `asString($value)` Converts input value to a string, but passes `null`.

### Converters
* `blankAsNull($value)` Converts input value to `null`, if it is a blank string `''`.
* `falseAsNull($value)` Converts input value to `null`, if it is a boolean `false`.
* `falsyAsNull($value)` Converts input value to `null`, if it is a falsy value `false`, `''`, `0`, ...
* `zeroAsNull($value)` Converts input value to `null`, if it is a zero `0` or `0.0`.

### Assertions
* `notNull($value)` Throws an exception if the value is `null` otherwise it passes the original value.

## Configuration

### Setting the default target time zone of `DateTimeImmutable` objects
```php
use Plook\TypeGuard\TypeGuard;

TypeGuard::instance()->timeZone('Australia/Adelaide');
TypeGuard::instance()->timeZone(new DateTimeZone('Australia/Adelaide'));
```

### Setting the default format of date time strings
```php
use Plook\TypeGuard\TypeGuard;

TypeGuard::instance()->dateTimeFormat(DateTimeInterface::ATOM);
```
