<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\TypeGuard\NotConvertable;
use Plook\TypeGuard\TypeGuard;
use stdClass;

use function Plook\TypeGuard\zeroAsNull;

#[CoversClass(TypeGuard::class)]
#[CoversClass(NotConvertable::class)]
#[CoversFunction('Plook\TypeGuard\zeroAsNull')]
final class ZeroAsNullTest extends TestCase
{
    public function testConvertsZeroIntToNull(): void
    {
        self::assertNull(zeroAsNull(0));
    }

    public function testConvertsZeroFloatToNull(): void
    {
        self::assertNull(zeroAsNull(0.0));
    }

    public function testDoesNotTouchInts(): void
    {
        self::assertSame(1000, zeroAsNull(1000));
    }

    public function testDoesNotTouchFloats(): void
    {
        self::assertSame(1234.567, zeroAsNull(1234.567));
    }

    public function testDoesNotTouchStrings(): void
    {
        self::assertSame('String', zeroAsNull('String'));
    }

    public function testDoesNotTouchBlanks(): void
    {
        self::assertSame('', zeroAsNull(''));
    }

    public function testDoesTouchTrue(): void
    {
        self::assertTrue(zeroAsNull(true));
    }

    public function testDoesTouchFalse(): void
    {
        self::assertFalse(zeroAsNull(false));
    }

    public function testDoesNotTouchObjects(): void
    {
        $object = new stdClass();

        self::assertSame($object, zeroAsNull($object));
    }
}
