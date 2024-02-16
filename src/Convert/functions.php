<?php

declare(strict_types=1);

namespace Plook\TypeGuard\Convert;

use DateTimeImmutable;

use function function_exists;

// phpcs:disable Squiz.Functions.GlobalFunction.Found

if (!function_exists('\Plook\TypeGuard\asBool')) { // @codeCoverageIgnore

    /** @return ($value is null ? null : bool) */
    function asBool(mixed $value): bool|null
    {
        return Convert::instance()->asBool($value);
    }
}

if (!function_exists('\Plook\TypeGuard\asFloat')) { // @codeCoverageIgnore

    /** @return ($value is null ? null : float) */
    function asFloat(mixed $value): float|null
    {
        return Convert::instance()->asFloat($value);
    }
}

if (!function_exists('\Plook\TypeGuard\asInt')) { // @codeCoverageIgnore

    /** @return ($value is null ? null : int) */
    function asInt(mixed $value): int|null
    {
        return Convert::instance()->asInt($value);
    }
}

if (!function_exists('\Plook\TypeGuard\asString')) { // @codeCoverageIgnore

    /** @return ($value is null ? null : string) */
    function asString(mixed $value): string|null
    {
        return Convert::instance()->asString($value);
    }
}

if (!function_exists('\Plook\TypeGuard\asDateTimeImmutable')) { // @codeCoverageIgnore

    /** @return ($value is null ? null : DateTimeImmutable) */
    function asDateTimeImmutable(mixed $value): DateTimeImmutable|null
    {
        return Convert::instance()->asDateTimeImmutable($value);
    }
}

if (!function_exists('\Plook\TypeGuard\asDateTimeString')) { // @codeCoverageIgnore

    /** @return ($value is null ? null : string) */
    function asDateTimeString(mixed $value): string|null
    {
        return Convert::instance()->asDateTimeString($value);
    }
}
