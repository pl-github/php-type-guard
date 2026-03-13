<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard;

use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\Tests\TypeGuard\Helper\StringableString;
use Plook\TypeGuard\NotConvertable;
use Plook\TypeGuard\TypeGuard;

use function basename;
use function Plook\TypeGuard\asDateTimeImmutable;
use function sprintf;

#[CoversClass(TypeGuard::class)]
#[CoversClass(NotConvertable::class)]
#[CoversFunction('Plook\TypeGuard\asDateTimeImmutable')]
#[CoversFunction('Plook\TypeGuard\asString')]
final class AsDateTimeImmutableTest extends TestCase
{
    private readonly DateTimeZone $originalTimeZone;

    protected function setUp(): void
    {
        $this->originalTimeZone = TypeGuard::instance()->timeZone();
    }

    protected function tearDown(): void
    {
        TypeGuard::instance()->timeZone($this->originalTimeZone);
    }

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
        $result = asDateTimeImmutable(new DateTimeImmutable('2010-09-08T07:06:05', TypeGuard::instance()->timeZone()));

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('2010-09-08T07:06:05+00:00', $result->format('c'));
    }

    public function testConvertsDateTimeImmutableWithDifferentTimeZone(): void
    {
        $dateTimeZone = new DateTimeZone('Australia/Adelaide');

        $result = asDateTimeImmutable(new DateTimeImmutable('2010-09-08T07:06:05', $dateTimeZone));

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('2010-09-07T21:36:05+00:00', $result->format('c'));
    }

    public function testConvertsDateTimeImmutableDefaultTimeZoneCanBeChangedByDateTimeZone(): void
    {
        TypeGuard::instance()->timeZone(new DateTimeZone('Australia/Adelaide'));

        $result = asDateTimeImmutable(new DateTimeImmutable('2010-09-08T07:06:05+00:00'));

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('2010-09-08T16:36:05+09:30', $result->format('c'));
    }

    public function testConvertsDateTimeImmutableDefaultTimeZoneCanBeChangedByTimeZoneName(): void
    {
        TypeGuard::instance()->timeZone('Australia/Adelaide');

        $result = asDateTimeImmutable(new DateTimeImmutable('2010-09-08T07:06:05+00:00'));

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('2010-09-08T16:36:05+09:30', $result->format('c'));
    }

    public function testDoesNotTouchNull(): void
    {
        self::assertNull(asDateTimeImmutable(null));
    }

    public function testTimezoneParameterOverridesDefaultWithDateTimeZone(): void
    {
        $result = asDateTimeImmutable('2010-09-08 07:06:05', new DateTimeZone('Australia/Adelaide'));

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('2010-09-08T07:06:05+09:30', $result->format('c'));
    }

    public function testTimezoneParameterOverridesDefaultWithString(): void
    {
        $result = asDateTimeImmutable('2010-09-08 07:06:05', 'Australia/Adelaide');

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('2010-09-08T07:06:05+09:30', $result->format('c'));
    }

    public function testTimezoneParameterOverridesChangedDefault(): void
    {
        TypeGuard::instance()->timeZone('Europe/Berlin');

        $result = asDateTimeImmutable('2010-09-08 07:06:05', 'Australia/Adelaide');

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('2010-09-08T07:06:05+09:30', $result->format('c'));
    }

    public function testTimezoneParameterConvertsSameDateTimeImmutable(): void
    {
        $input = new DateTimeImmutable('2010-09-08T07:06:05', new DateTimeZone('Australia/Adelaide'));

        $result = asDateTimeImmutable($input, 'Australia/Adelaide');

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('Australia/Adelaide', $result->getTimezone()->getName());
        self::assertSame('2010-09-08T07:06:05+09:30', $result->format('c'));
    }

    public function testTimezoneParameterConvertsDifferentDateTimeImmutable(): void
    {
        $input = new DateTimeImmutable('2010-09-08T07:06:05+00:00');

        $result = asDateTimeImmutable($input, new DateTimeZone('Australia/Adelaide'));

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('2010-09-08T16:36:05+09:30', $result->format('c'));
    }

    public function testNullTimezoneParameterUsesDefault(): void
    {
        TypeGuard::instance()->timeZone('Australia/Adelaide');

        $result = asDateTimeImmutable('2010-09-08 07:06:05');

        self::assertInstanceOf(DateTimeImmutable::class, $result);
        self::assertSame('2010-09-08T07:06:05+09:30', $result->format('c'));
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
