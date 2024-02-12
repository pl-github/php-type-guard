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
use function Plook\TypeGuard\Convert\asString;
use function sprintf;

#[CoversClass(Convert::class)]
#[CoversClass(NotConvertable::class)]
#[CoversFunction('\Plook\TypeGuard\Convert\asString')]
final class AsStringTest extends TestCase
{
    public function testDoesNotTouchStrings(): void
    {
        self::assertSame('1000', asString('1000'));
    }

    public function testConvertsStrings(): void
    {
        self::assertSame('1000', asString(1000));
    }

    public function testConvertsStringables(): void
    {
        self::assertSame('1000', asString(new StringableInt(1000)));
    }

    public function testConvertsFloats(): void
    {
        self::assertSame('1000.1', asString(1000.1));
    }

    public function testDoesNotTouchNull(): void
    {
        self::assertNull(asString(null));
    }

    public function testOnlyScalarsAreConvertable(): void
    {
        $this->expectException(NotConvertable::class);
        $this->expectExceptionMessageMatches(
            sprintf(
                '/Closure is not convertable to string in %s:%s/',
                basename(__FILE__),
                __LINE__ + 4,
            ),
        );

        asSTring(static fn (): null => null);
    }
}
