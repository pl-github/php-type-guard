<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard\Convert;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\Tests\TypeGuard\StringableFloat;
use Plook\TypeGuard\Convert\Convert;
use Plook\TypeGuard\Convert\NotConvertable;

use function basename;
use function Plook\TypeGuard\Convert\asFloat;
use function sprintf;

#[CoversClass(Convert::class)]
#[CoversClass(NotConvertable::class)]
#[CoversFunction('\Plook\TypeGuard\Convert\asFloat')]
final class AsFloatTest extends TestCase
{
    public function testDoesNotTouchFloats(): void
    {
        self::assertSame(1000.9, asFloat(1000.9));
    }

    public function testConvertsStrings(): void
    {
        self::assertSame(1000.9, asFloat('1000.9'));
    }

    public function testConvertsStringables(): void
    {
        self::assertSame(1000.9, asFloat(new StringableFloat(1000.9)));
    }

    public function testConvertsInts(): void
    {
        self::assertSame(1000.0, asFloat(1000));
    }

    public function testDoesNotTouchNull(): void
    {
        self::assertNull(asFloat(null));
    }

    public function testOnlyScalarsAreConvertable(): void
    {
        $this->expectException(NotConvertable::class);
        $this->expectExceptionMessageMatches(
            sprintf(
                '/Closure is not convertable to float in %s:%s/',
                basename(__FILE__),
                __LINE__ + 4,
            ),
        );

        asFloat(static fn (): null => null);
    }
}
