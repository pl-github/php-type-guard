<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\TypeGuard\InvalidValue;
use Plook\TypeGuard\TypeGuard;
use stdClass;

use function basename;
use function Plook\TypeGuard\notNull;
use function sprintf;

#[CoversClass(TypeGuard::class)]
#[CoversClass(InvalidValue::class)]
#[CoversFunction('\Plook\TypeGuard\notNull')]
final class NotNullTest extends TestCase
{
    public function testDoesNotTouchInts(): void
    {
        self::assertSame(1000, notNull(1000));
    }

    public function testDoesNotTouchStrings(): void
    {
        self::assertSame('1000', notNull('1000'));
    }

    public function testDoesNotTouchFloats(): void
    {
        self::assertSame(1000.1, notNull(1000.1));
    }

    public function testDoesNotTouchObjects(): void
    {
        $object = new stdClass();

        self::assertSame($object, notNull($object));
    }

    public function testDetectsNulls(): void
    {
        $this->expectException(InvalidValue::class);
        $this->expectExceptionMessageMatches(
            sprintf(
                '/null.* %s:%s/',
                basename(__FILE__),
                __LINE__ + 4,
            ),
        );

        notNull(null);
    }
}
