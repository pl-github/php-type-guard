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
    private DateTimeZone|null $dateTimeZone = null;

    private string $dateTimeFormat = 'c';

    public static function instance(): self
    {
        static $instance = new self();

        return $instance;
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

    /** @return ($value is null ? null : DateTimeImmutable) */
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
}
