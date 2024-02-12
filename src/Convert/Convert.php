<?php

declare(strict_types=1);

namespace Plook\TypeGuard\Convert;

use DateTimeImmutable;
use DateTimeZone;
use Stringable;

use function ini_get;
use function is_bool;
use function is_float;
use function is_int;
use function is_scalar;
use function is_string;

final class Convert
{
    private static DateTimeZone|null $dateTimeZone = null;

    /** @return ($value is null ? null : bool) */
    public static function asBool(mixed $value): bool|null
    {
        if ($value === null) {
            return null;
        }

        if (is_bool($value)) {
            return $value;
        }

        if ($value instanceof Stringable) {
            $value = (string) $value;
        }

        if (!is_scalar($value)) {
            throw NotConvertable::toBool($value);
        }

        return (bool) $value;
    }

    /** @return ($value is null ? null : float) */
    public static function asFloat(mixed $value): float|null
    {
        if ($value === null) {
            return null;
        }

        if (is_float($value)) {
            return $value;
        }

        if ($value instanceof Stringable) {
            $value = (string) $value;
        }

        if (!is_scalar($value)) {
            throw NotConvertable::toFloat($value);
        }

        return (float) $value;
    }

    /** @return ($value is null ? null : int) */
    public static function asInt(mixed $value): int|null
    {
        if ($value === null) {
            return null;
        }

        if (is_int($value)) {
            return $value;
        }

        if ($value instanceof Stringable) {
            $value = (string) $value;
        }

        if (!is_scalar($value)) {
            throw NotConvertable::toInteger($value);
        }

        return (int) $value;
    }

    /** @return ($value is null ? null : string) */
    public static function asString(mixed $value): string|null
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            return $value;
        }

        if ($value instanceof Stringable) {
            return (string) $value;
        }

        if (!is_scalar($value)) {
            throw NotConvertable::toString($value);
        }

        return (string) $value;
    }

    /** @return ($value is null ? null : DateTimeImmutable) */
    public static function asDateTimeImmutable(mixed $value): DateTimeImmutable|null
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof DateTimeImmutable) {
            if ($value->getTimezone()->getName() === self::timeZone()->getName()) {
                return $value;
            }

            return $value->setTimezone(self::timeZone());
        }

        if ($value instanceof Stringable) {
            $value = (string) $value;
        }

        if (!is_scalar($value)) {
            throw NotConvertable::toDateTime($value);
        }

        return new DateTimeImmutable(asString($value), self::timeZone());
    }

    /** @return ($value is null ? null : string) */
    public static function asDateTimeString(mixed $value): string|null
    {
        if ($value === null) {
            return null;
        }

        $value = asDateTimeImmutable($value);

        return $value->format('c');
    }

    private static function timeZone(): DateTimeZone
    {
        if (!self::$dateTimeZone instanceof DateTimeZone) {
            self::$dateTimeZone = new DateTimeZone(ini_get('date.timezone'));
        }

        return self::$dateTimeZone;
    }
}
