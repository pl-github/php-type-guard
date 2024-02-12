<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard\Convert;

use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\Tests\TypeGuard\StringableString;
use Plook\TypeGuard\Convert\Convert;
use Plook\TypeGuard\Convert\NotConvertable;

use function basename;
use function Plook\TypeGuard\Convert\asDateTimeImmutable;
use function sprintf;

#[CoversClass(Convert::class)]
#[CoversClass(NotConvertable::class)]
#[CoversFunction('\Plook\TypeGuard\Convert\asDateTimeImmutable')]
#[CoversFunction('\Plook\TypeGuard\Convert\asString')]
final class AsDateTimeImmutableTest extends TestCase
{
    public function testConvertsStrings(): void
    {
        $result = asDateTimeImmutable('2010-09-08T07:06:05+02:00');

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('2010-09-08T07:06:05+02:00', $result->format('c'));
    }

    public function testConvertsStringables(): void
    {
        $result = asDateTimeImmutable(new StringableString('2010-09-08T07:06:05+00:00'));

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('2010-09-08T07:06:05+00:00', $result->format('c'));
    }

    public function testConvertsDateTimeImmutableWithSameTimeZone(): void
    {
        $dateTimeZone = asDateTimeImmutable(new DateTimeImmutable())->getTimezone();

        $result = asDateTimeImmutable(new DateTimeImmutable('2010-09-08T07:06:05+00:00', $dateTimeZone));

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('2010-09-08T07:06:05+00:00', $result->format('c'));
    }

    public function testConvertsDateTimeImmutableWithDifferentTimeZone(): void
    {
        $result = asDateTimeImmutable(new DateTimeImmutable('2010-09-08T07:06:05+02:00'));

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('2010-09-08T05:06:05+00:00', $result->format('c'));
    }

    public function testDoesNotTouchNull(): void
    {
        self::assertNull(asDateTimeImmutable(null));
    }

    public function testOnlyScalarsAreConvertable(): void
    {
        $this->expectException(NotConvertable::class);
        $this->expectExceptionMessageMatches(
            sprintf(
                '/Closure is not convertable to date time object in %s:%s/',
                basename(__FILE__),
                __LINE__ + 4,
            ),
        );

        asDateTimeImmutable(static fn (): null => null);
    }
}
