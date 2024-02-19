<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard\Helper;

use Stringable;

final readonly class StringableString implements Stringable
{
    public function __construct(private string $value)
    {
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
