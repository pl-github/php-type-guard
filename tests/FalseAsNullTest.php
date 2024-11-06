<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\TypeGuard\NotConvertable;
use Plook\TypeGuard\TypeGuard;
use stdClass;

use function Plook\TypeGuard\falseAsNull;

#[CoversClass(TypeGuard::class)]
#[CoversClass(NotConvertable::class)]
#[CoversFunction('\Plook\TypeGuard\falseAsNull')]
final class FalseAsNullTest extends TestCase
{
    public function testConvertsFalseToNull(): void
    {
        self::assertNull(falseAsNull(false));
    }

    public function testDoesTouchTrue(): void
    {
        self::assertTrue(falseAsNull(true));
    }

    public function testDoesNotTouchStrings(): void
    {
        self::assertSame('String', falseAsNull('String'));
    }

    public function testDoesNotTouchBlanks(): void
    {
        self::assertSame('', falseAsNull(''));
    }

    public function testDoesNotTouchInts(): void
    {
        self::assertSame(1000, falseAsNull(1000));
    }

    public function testDoesNotTouchZero(): void
    {
        self::assertSame(0, falseAsNull(0));
    }

    public function testDoesNotTouchObjects(): void
    {
        $object = new stdClass();

        self::assertSame($object, falseAsNull($object));
    }
}
