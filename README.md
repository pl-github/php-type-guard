# Type Guard

[![codecov](https://codecov.io/gh/pl-github/php-TYPE-GUARD/graph/badge.svg?token=IYNVCXQS8A)](https://codecov.io/gh/pl-github/php-TYPE-GUARD)

A PHP library to ensure correctness of types providing a readable interface.

The library is helpfull to

## Example

```php
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

### Type Conversion
* `asBool($value)` Converts input value to a boolean, but passes `null`.
* `asFloat($value)` Converts input value to a float, but passes `null`.
* `asInt($value)` Converts input value to a int, but passes `null`.
* `asDateTimeImmutable($value)` Converts input value to a `DateTimeImmutable` object, but passes `null`.
* `asDateTimeString($value)` Converts input value to a date string including the timezone, but passes `null`.
* `asString($value)` Converts input value to a string, but passes `null`.

### Assertions
* `notNull($value)` Throws an exception if the value is `null` otherwise it passes the original value.

## Installation

```shell
$ composer require plook/type-guard
```

## Configuration

### Setting the default target time zone of `DateTimeImmutable` objects
```php
Convert::instance()->timeZone('Australia/Adelaide');
Convert::instance()->timeZone(new DateTimeZone('Australia/Adelaide'));
```

### Setting the default format of date time strings
```php
Convert::instance()->dateTimeFormat(DateTimeInterface::ATOM);
```
