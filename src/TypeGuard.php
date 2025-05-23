<?php

declare(strict_types=1);

namespace Plook\TypeGuard;

use DateTimeImmutable;
use DateTimeZone;
use Stringable;

use function ini_get;
use function is_bool;
use function is_float;
use function is_int;
use function is_scalar;
use function is_string;

final class TypeGuard
{
    private DateTimeZone|null $dateTimeZone = null;

    private string $dateTimeFormat = 'c';

    private static TypeGuard $typeGuard;

    public static function instance(): self
    {
        self::$typeGuard ??= new self();

        return self::$typeGuard;
    }

    /** @return ($value is null ? null : bool) */
    public function asBool(mixed $value): bool|null
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
    public function asFloat(mixed $value): float|null
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
    public function asInt(mixed $value): int|null
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
    public function asString(mixed $value): string|null
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

    /** @return DateTimeImmutable */
    public function asDateTimeImmutable(mixed $value): DateTimeImmutable|null
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof DateTimeImmutable) {
            if ($value->getTimezone()->getName() === $this->timeZone()->getName()) {
                return $value;
            }

            return $value->setTimezone($this->timeZone());
        }

        if ($value instanceof Stringable) {
            $value = (string) $value;
        }

        if (!is_scalar($value)) {
            throw NotConvertable::toDateTime($value);
        }

        return new DateTimeImmutable(asString($value), $this->timeZone());
    }

    /** @return ($value is null ? null : string) */
    public function asDateTimeString(mixed $value): string|null
    {
        if ($value === null) {
            return null;
        }

        $value = asDateTimeImmutable($value);

        return $value->format($this->dateTimeFormat());
    }

    /**
     * @param T $value
     *
     * @return T|null
     *
     * @template T
     */
    public function blankAsNull(mixed $value): mixed
    {
        if ($value === '') {
            return null;
        }

        return $value;
    }

    /**
     * @param T $value
     *
     * @return T|null
     *
     * @template T
     */
    public function falseAsNull(mixed $value): mixed
    {
        if ($value === false) {
            return null;
        }

        return $value;
    }

    /**
     * @param T $value
     *
     * @return T|null
     *
     * @template T
     */
    public function zeroAsNull(mixed $value): mixed
    {
        if ($value === 0 || $value === 0.0) {
            return null;
        }

        return $value;
    }

    /**
     * @param T $value
     *
     * @return T|null
     *
     * @template T
     */
    public function falsyAsNull(mixed $value): mixed
    {
        if (! (bool) $value) {
            return null;
        }

        return $value;
    }

    public function timeZone(DateTimeZone|string|null $timeZone = null): DateTimeZone
    {
        if (is_string($timeZone)) {
            $this->dateTimeZone = new DateTimeZone($timeZone);
        } elseif ($timeZone instanceof DateTimeZone) {
            $this->dateTimeZone = $timeZone;
        } elseif (!$this->dateTimeZone instanceof DateTimeZone) {
            $this->dateTimeZone = new DateTimeZone(ini_get('date.timezone'));
        }

        return $this->dateTimeZone;
    }

    public function dateTimeFormat(string|null $dateTimeFormat = null): string
    {
        if ($dateTimeFormat !== null) {
            $this->dateTimeFormat = $dateTimeFormat;
        }

        return $this->dateTimeFormat;
    }

    /**
     * @param ?T $value
     *
     * @return T
     *
     * @template T
     */
    public function notNull(mixed $value): mixed
    {
        if ($value === null) {
            throw InvalidValue::null();
        }

        return $value;
    }
}
