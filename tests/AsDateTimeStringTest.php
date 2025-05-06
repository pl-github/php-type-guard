<?php

declare(strict_types=1);

namespace Plook\Tests\TypeGuard;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use Plook\Tests\TypeGuard\Helper\StringableString;
use Plook\TypeGuard\NotConvertable;
use Plook\TypeGuard\TypeGuard;

use function basename;
use function Plook\TypeGuard\asDateTimeString;
use function sprintf;

#[CoversClass(TypeGuard::class)]
#[CoversClass(NotConvertable::class)]
#[CoversFunction('Plook\TypeGuard\asDateTimeString')]
#[CoversFunction('Plook\TypeGuard\asDateTimeImmutable')]
#[CoversFunction('Plook\TypeGuard\asString')]
final class AsDateTimeStringTest extends TestCase
{
    private readonly string $originalDateTimeFormat;

    protected function setUp(): void
    {
        $this->originalDateTimeFormat = TypeGuard::instance()->dateTimeFormat();
    }

    protected function tearDown(): void
    {
        TypeGuard::instance()->dateTimeFormat($this->originalDateTimeFormat);
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
        TypeGuard::instance()->dateTimeFormat('Y-m-d');

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
