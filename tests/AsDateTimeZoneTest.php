<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard;

use DateTimeZone;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\Tests\TypeGuard\Helper\StringableString;
use Plook\TypeGuard\NotConvertable;
use Plook\TypeGuard\TypeGuard;

use function basename;
use function Plook\TypeGuard\asDateTimeZone;
use function sprintf;

#[CoversClass(TypeGuard::class)]
#[CoversClass(NotConvertable::class)]
#[CoversFunction('Plook\TypeGuard\asDateTimeZone')]
final class AsDateTimeZoneTest extends TestCase
{
    public function testConvertsStrings(): void
    {
        $dateTimeZone = asDateTimeZone('Europe/Berlin');

        self::assertInstanceOf(DateTimeZone::class, $dateTimeZone);
        self::assertSame('Europe/Berlin', $dateTimeZone->getName());
    }

    public function testConvertsStringables(): void
    {
        $dateTimeZone = asDateTimeZone(new StringableString('Australia/Adelaide'));

        self::assertInstanceOf(DateTimeZone::class, $dateTimeZone);
        self::assertSame('Australia/Adelaide', $dateTimeZone->getName());
    }

    public function testReturnsSameDateTimeZone(): void
    {
        $dateTimeZone = new DateTimeZone('Europe/Berlin');

        $result = asDateTimeZone($dateTimeZone);

        self::assertSame($dateTimeZone, $result);
    }

    public function testDoesNotTouchNull(): void
    {
        self::assertNull(asDateTimeZone(null));
    }

    public function testOnlyStringsAreConvertable(): void
    {
        $this->expectException(NotConvertable::class);
        $this->expectExceptionMessageMatches(
            sprintf(
                '/Closure is not convertable to date time zone in %s:%s/',
                basename(__FILE__),
                __LINE__ + 4,
            ),
        );

        asDateTimeZone(static fn (): null => null);
    }
}
