<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard\Helper;

use Stringable;

final readonly class StringableInt implements Stringable
{
    public function __construct(private int $value)
    {
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
