<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\Tests\TypeGuard\Helper\StringableInt;
use Plook\TypeGuard\NotConvertable;
use Plook\TypeGuard\TypeGuard;

use function basename;
use function Plook\TypeGuard\asInt;
use function sprintf;

#[CoversClass(TypeGuard::class)]
#[CoversClass(NotConvertable::class)]
#[CoversFunction('Plook\TypeGuard\asInt')]
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
