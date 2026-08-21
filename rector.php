<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitSelfCallRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/rector.php',
    ]);

    $rectorConfig->phpstanConfig(__DIR__ . '/phpstan.neon.dist');

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_84,

        PHPUnitSetList::PHPUNIT_MOCK_TO_STUB,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        PHPUnitSetList::PHPUNIT_NARROW_ASSERTS,
        PHPUnitSetList::ANNOTATIONS_TO_ATTRIBUTES,
        PHPUnitSetList::COMPOSER_BASED,

        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        SetList::NAMING,
        SetList::PRIVATIZATION,
        SetList::TYPE_DECLARATION,
        SetList::EARLY_RETURN,
        SetList::INSTANCEOF,
    ]);

    $rectorConfig->rules([
        DeclareStrictTypesRector::class,
        PreferPHPUnitSelfCallRector::class,
    ]);

    $rectorConfig->skip([
        PreferPHPUnitThisCallRector::class,
        // phpcs:ignore Squiz.Arrays.ArrayDeclaration.KeySpecified
        RenamePropertyToMatchTypeRector::class => [
            __DIR__ . '/tests',
        ],
    ]);
};
