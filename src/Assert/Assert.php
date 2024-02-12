<?php

declare(strict_types=1);

namespace Plook\TypeGuard\Assert;

final class Assert
{
    /**
     * @param ?T $value
     *
     * @return T
     *
     * @template T
     */
    public static function notNull(mixed $value): mixed
    {
        if ($value === null) {
            throw InvalidValue::null();
        }

        return $value;
    }
}
