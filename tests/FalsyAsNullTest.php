<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\TypeGuard\NotConvertable;
use Plook\TypeGuard\TypeGuard;
use stdClass;

use function Plook\TypeGuard\falsyAsNull;

#[CoversClass(TypeGuard::class)]
#[CoversClass(NotConvertable::class)]
#[CoversFunction('\Plook\TypeGuard\falsyAsNull')]
final class FalsyAsNullTest extends TestCase
{
    public function testConvertsBlankToNull(): void
    {
        self::assertNull(falsyAsNull(''));
    }

    public function testDoesNotTouchStrings(): void
    {
        self::assertSame('String', falsyAsNull('String'));
    }

    public function testConvertsZeroIntToNUll(): void
    {
        self::assertNull(falsyAsNull(0));
    }

    public function testConvertsZeroFloatToNull(): void
    {
        self::assertNull(falsyAsNull(0.0));
    }

    public function testDoesNotTouchInts(): void
    {
        self::assertSame(1000, falsyAsNull(1000));
    }

    public function testDoesNotTouchFloats(): void
    {
        self::assertSame(1234.56, falsyAsNull(1234.56));
    }

    public function testConvertsFalseToNull(): void
    {
        self::assertNull(falsyAsNull(false));
    }

    public function testDoesTouchTrue(): void
    {
        self::assertTrue(falsyAsNull(true));
    }

    public function testDoesNotTouchObjects(): void
    {
        $object = new stdClass();

        self::assertSame($object, falsyAsNull($object));
    }
}
