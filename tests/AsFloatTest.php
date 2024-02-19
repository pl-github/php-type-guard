<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\Tests\TypeGuard\Helper\StringableFloat;
use Plook\TypeGuard\NotConvertable;
use Plook\TypeGuard\TypeGuard;

use function basename;
use function Plook\TypeGuard\asFloat;
use function sprintf;

#[CoversClass(TypeGuard::class)]
#[CoversClass(NotConvertable::class)]
#[CoversFunction('\Plook\TypeGuard\asFloat')]
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
