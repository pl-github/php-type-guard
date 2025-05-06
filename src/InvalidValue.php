<?php

declare(strict_types=1);

namespace Plook\TypeGuard;

use InvalidArgumentException;

use function basename;
use function sprintf;
use function str_contains;

final class InvalidValue extends InvalidArgumentException
{
    public static function null(): self
    {
        return self::withMessage('Value should not be null');
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
