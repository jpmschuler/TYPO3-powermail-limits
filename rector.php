<?php
declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\PostRector\Rector\NameImportingPostRector;
use Ssch\TYPO3Rector\Configuration\Typo3Option;
use Ssch\TYPO3Rector\Rector\General\ConvertImplicitVariablesToExplicitGlobalsRector;
use Ssch\TYPO3Rector\Rector\General\ExtEmConfRector;
use Ssch\TYPO3Rector\Set\Typo3LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $parameters = $rectorConfig->parameters();
    $parameters->set(Typo3Option::TYPOSCRIPT_INDENT_SIZE, 2);
    $rectorConfig->import(Typo3LevelSetList::UP_TO_TYPO3_10);
    $rectorConfig->phpVersion(PhpVersion::PHP_74);
    $rectorConfig->importNames();
    $rectorConfig->skip([
        NameImportingPostRector::class => [
            'ClassAliasMap.php',
            'ext_localconf.php',
            'ext_emconf.php',
            'ext_tables.php',
            'Configuration/TCA/*',
            'Configuration/TCA/Overrides/*',
            'Configuration/RequestMiddlewares.php',
            'Configuration/Commands.php',
            'Configuration/AjaxRoutes.php',
            'Configuration/Extbase/Persistence/Classes.php',
        ],
        __DIR__ . '/**/Resources/**/node_modules/*',
        __DIR__ . '/**/Resources/**/NodeModules/*',
        __DIR__ . '/**/Resources/**/BowerComponents/*',
        __DIR__ . '/**/Resources/**/bower_components/*',
        __DIR__ . '/**/Resources/**/build/*',
        __DIR__ . '/.gitlab',
        __DIR__ . '/.github',
        __DIR__ . '/.Build'
    ]);

    $rectorConfig->rule(ConvertImplicitVariablesToExplicitGlobalsRector::class);
    $rectorConfig->ruleWithConfiguration(ExtEmConfRector::class, [
        ExtEmConfRector::ADDITIONAL_VALUES_TO_BE_REMOVED => []
    ]);
};
