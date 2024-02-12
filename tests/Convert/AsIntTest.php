<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard\Convert;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\Tests\TypeGuard\StringableInt;
use Plook\TypeGuard\Convert\Convert;
use Plook\TypeGuard\Convert\NotConvertable;

use function basename;
use function Plook\TypeGuard\Convert\asInt;
use function sprintf;

#[CoversClass(Convert::class)]
#[CoversClass(NotConvertable::class)]
#[CoversFunction('\Plook\TypeGuard\Convert\asInt')]
final class AsIntTest extends TestCase
{
    public function testDoesNotTouchInts(): void
    {
        self::assertSame(1000, asInt(1000));
    }

    public function testConvertsStrings(): void
    {
        self::assertSame(1000, asInt('1000'));
    }

    public function testConvertsStringables(): void
    {
        self::assertSame(1000, asInt(new StringableInt(1000)));
    }

    public function testConvertsFloats(): void
    {
        self::assertSame(1000, asInt(1000.1));
    }

    public function testDoesNotTouchNull(): void
    {
        self::assertNull(asInt(null));
    }

    public function testOnlyScalarsAreConvertable(): void
    {
        $this->expectException(NotConvertable::class);
        $this->expectExceptionMessageMatches(
            sprintf(
                '/Closure is not convertable to integer in %s:%s/',
                basename(__FILE__),
                __LINE__ + 4,
            ),
        );

        asInt(static fn (): null => null);
    }
}
