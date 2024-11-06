<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\TypeGuard\NotConvertable;
use Plook\TypeGuard\TypeGuard;
use stdClass;

use function Plook\TypeGuard\blankAsNull;

#[CoversClass(TypeGuard::class)]
#[CoversClass(NotConvertable::class)]
#[CoversFunction('\Plook\TypeGuard\blankAsNull')]
final class BlankAsNullTest extends TestCase
{
    public function testConvertsBlankToNull(): void
    {
        self::assertNull(blankAsNull(''));
    }

    public function testDoesNotTouchStrings(): void
    {
        self::assertSame('String', blankAsNull('String'));
    }

    public function testDoesNotTouchInts(): void
    {
        self::assertSame(1000, blankAsNull(1000));
    }

    public function testDoesNotTouchZero(): void
    {
        self::assertSame(0, blankAsNull(0));
    }

    public function testDoesTouchTrue(): void
    {
        self::assertTrue(blankAsNull(true));
    }

    public function testDoesTouchFalse(): void
    {
        self::assertFalse(blankAsNull(false));
    }

    public function testDoesNotTouchObjects(): void
    {
        $object = new stdClass();

        self::assertSame($object, blankAsNull($object));
    }
}
