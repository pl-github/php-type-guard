<?php

declare(strict_types=1);

namespace Plook\TypeGuard;

use InvalidArgumentException;

use function basename;
use function get_debug_type;
use function sprintf;
use function str_contains;

final class NotConvertable extends InvalidArgumentException
{
    public static function toBool(mixed $value): self
    {
        return self::withMessage(sprintf('%s is not convertable to bool', get_debug_type($value)));
    }

    public static function toFloat(mixed $value): self
    {
        return self::withMessage(sprintf('%s is not convertable to float', get_debug_type($value)));
    }

    public static function toInteger(mixed $value): self
    {
        return self::withMessage(sprintf('%s is not convertable to integer', get_debug_type($value)));
    }

    public static function toString(mixed $value): self
    {
        return self::withMessage(sprintf('%s is not convertable to string', get_debug_type($value)));
    }

    public static function toDateTime(mixed $value): self
    {
        return self::withMessage(sprintf('%s is not convertable to date time object', get_debug_type($value)));
    }

    private static function withMessage(string $message): self
    {
        $me = new self($message);

        foreach ($me->getTrace() as $trace) {
            $file = $trace['file'] ?? null;
            $line = $trace['line'] ?? null;

            if ($file !== null && $line !== null && !str_contains($file, __DIR__)) {
                $me->message = sprintf('%s in %s:%s', $message, basename($file), $line);
                break;
            }
        }

        return $me;
    }
}
