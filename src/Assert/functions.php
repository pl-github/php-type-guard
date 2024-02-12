<?php

declare(strict_types=1);

namespace Plook\TypeGuard\Assert;

use function function_exists;

// phpcs:disable Squiz.Functions.GlobalFunction.Found

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
        return Assert::notNull($value);
    }
}
