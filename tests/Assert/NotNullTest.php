<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard\Assert;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\TypeGuard\Assert\Assert;
use Plook\TypeGuard\Assert\InvalidValue;
use stdClass;

use function basename;
use function Plook\TypeGuard\Assert\notNull;
use function sprintf;

#[CoversClass(Assert::class)]
#[CoversClass(InvalidValue::class)]
#[CoversFunction('\Plook\TypeGuard\Assert\notNull')]
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
