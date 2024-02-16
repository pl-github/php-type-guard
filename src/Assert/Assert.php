<?php

declare(strict_types=1);

namespace Plook\TypeGuard\Assert;

final class Assert
{
    public static function instance(): self
    {
        static $instance = new self();

        return $instance;
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
