<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard\Convert;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\Tests\TypeGuard\StringableInt;
use Plook\Tests\TypeGuard\StringableString;
use Plook\TypeGuard\Convert\Convert;
use Plook\TypeGuard\Convert\NotConvertable;

use function basename;
use function Plook\TypeGuard\Convert\asBool;
use function sprintf;

#[CoversClass(Convert::class)]
#[CoversClass(NotConvertable::class)]
#[CoversFunction('\Plook\TypeGuard\Convert\asBool')]
final class AsBoolTest extends TestCase
{
    public function testDoesNotTouchBools(): void
    {
        self::assertTrue(asBool(true));
        self::assertFalse(asBool(false));
    }

    public function testConvertsStrings(): void
    {
        self::assertTrue(asBool('1'));
        self::assertTrue(asBool('something else'));
        self::assertFalse(asBool('0'));
        self::assertFalse(asBool(''));
    }

    public function testConvertsStringables(): void
    {
        self::assertTrue(asBool(new StringableInt(1)));
        self::assertTrue(asBool(new StringableString('something else')));
        self::assertFalse(asBool(new StringableInt(0)));
        self::assertFalse(asBool(new StringableString('')));
    }

    public function testConvertsFloats(): void
    {
        self::assertTrue(asBool(1.0));
        self::assertFalse(asBool(0.0));
    }

    public function testConvertsInts(): void
    {
        self::assertTrue(asBool(1));
        self::assertFalse(asBool(0));
    }

    public function testDoesNotTouchNull(): void
    {
        self::assertNull(asBool(null));
    }

    public function testOnlyScalarsAreConvertable(): void
    {
        $this->expectException(NotConvertable::class);
        $this->expectExceptionMessageMatches(
            sprintf(
                '/Closure is not convertable to bool in %s:%s/',
                basename(__FILE__),
                __LINE__ + 4,
            ),
        );

        asBool(static fn (): null => null);
    }
}
