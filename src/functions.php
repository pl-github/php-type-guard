<?php

declare(strict_types=1);

namespace Plook\TypeGuard;

use DateTimeImmutable;

use function function_exists;

// phpcs:disable Squiz.Functions.GlobalFunction.Found

if (!function_exists('\Plook\TypeGuard\asBool')) { // @codeCoverageIgnore

    /** @return ($value is null ? null : bool) */
    function asBool(mixed $value): bool|null
    {
        return TypeGuard::instance()->asBool($value);
    }
}

if (!function_exists('\Plook\TypeGuard\asFloat')) { // @codeCoverageIgnore

    /** @return ($value is null ? null : float) */
    function asFloat(mixed $value): float|null
    {
        return TypeGuard::instance()->asFloat($value);
    }
}

if (!function_exists('\Plook\TypeGuard\asInt')) { // @codeCoverageIgnore

    /** @return ($value is null ? null : int) */
    function asInt(mixed $value): int|null
    {
        return TypeGuard::instance()->asInt($value);
    }
}

if (!function_exists('\Plook\TypeGuard\asString')) { // @codeCoverageIgnore

    /** @return ($value is null ? null : string) */
    function asString(mixed $value): string|null
    {
        return TypeGuard::instance()->asString($value);
    }
}

if (!function_exists('\Plook\TypeGuard\asDateTimeImmutable')) { // @codeCoverageIgnore

    /** @return ($value is null ? null : DateTimeImmutable) */
    function asDateTimeImmutable(mixed $value): DateTimeImmutable|null
    {
        return TypeGuard::instance()->asDateTimeImmutable($value);
    }
}

if (!function_exists('\Plook\TypeGuard\asDateTimeString')) { // @codeCoverageIgnore

    /** @return ($value is null ? null : string) */
    function asDateTimeString(mixed $value): string|null
    {
        return TypeGuard::instance()->asDateTimeString($value);
    }
}

if (!function_exists('\Plook\TypeGuard\blankAsNull')) { // @codeCoverageIgnore

    /**
     * @param T $value
     *
     * @return T|null
     *
     * @template T
     */
    function blankAsNull(mixed $value): mixed
    {
        return TypeGuard::instance()->blankAsNull($value);
    }
}

if (!function_exists('\Plook\TypeGuard\falseAsNull')) { // @codeCoverageIgnore

    /**
     * @param T $value
     *
     * @return T|null
     *
     * @template T
     */
    function falseAsNull(mixed $value): mixed
    {
        return TypeGuard::instance()->falseAsNull($value);
    }
}

if (!function_exists('\Plook\TypeGuard\zeroAsNull')) { // @codeCoverageIgnore

    /**
     * @param T $value
     *
     * @return T|null
     *
     * @template T
     */
    function zeroAsNull(mixed $value): mixed
    {
        return TypeGuard::instance()->zeroAsNull($value);
    }
}

if (!function_exists('\Plook\TypeGuard\falsyAsNull')) { // @codeCoverageIgnore

    /**
     * @param T $value
     *
     * @return T|null
     *
     * @template T
     */
    function falsyAsNull(mixed $value): mixed
    {
        return TypeGuard::instance()->falsyAsNull($value);
    }
}

if (!function_exists('\Plook\TypeGuard\notNull')) { // @codeCoverageIgnore

    /**
     * @param ?T $value
     *
     * @return T
     *
     * @template T
     */
    function notNull(mixed $value): mixed
    {
        return TypeGuard::instance()->notNull($value);
    }
}
