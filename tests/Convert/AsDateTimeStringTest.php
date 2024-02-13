<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard\Convert;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\Tests\TypeGuard\StringableString;
use Plook\TypeGuard\Convert\Convert;
use Plook\TypeGuard\Convert\NotConvertable;

use function basename;
use function Plook\TypeGuard\Convert\asDateTimeString;
use function sprintf;

#[CoversClass(Convert::class)]
#[CoversClass(NotConvertable::class)]
#[CoversFunction('\Plook\TypeGuard\Convert\asDateTimeString')]
#[CoversFunction('\Plook\TypeGuard\Convert\asDateTimeImmutable')]
#[CoversFunction('\Plook\TypeGuard\Convert\asString')]
final class AsDateTimeStringTest extends TestCase
{
    private readonly string $originalDateTimeFormat;

    protected function setUp(): void
    {
        $this->originalDateTimeFormat = Convert::dateTimeFormat();
    }

    protected function tearDown(): void
    {
        Convert::dateTimeFormat($this->originalDateTimeFormat);
    }

    public function testConvertsStrings(): void
    {
        self::assertSame('2010-09-08T07:06:05+02:00', asDateTimeString('2010-09-08T07:06:05+02:00'));
    }

    public function testConvertsStringables(): void
    {
        self::assertSame(
            '2010-09-08T07:06:05+02:00',
            asDateTimeString(new StringableString('2010-09-08T07:06:05+02:00')),
        );
    }

    public function testDateTimeFormatCanBeChanged(): void
    {
        Convert::dateTimeFormat('Y-m-d');

        self::assertSame('2010-09-08', asDateTimeString('2010-09-08T07:06:05+02:00'));
    }

    public function testDoesNotTouchNull(): void
    {
        self::assertNull(asDateTimeString(null));
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

        asDateTimeString(static fn (): null => null);
    }
}
