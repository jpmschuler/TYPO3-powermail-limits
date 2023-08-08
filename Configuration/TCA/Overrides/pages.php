<?php

defined('TYPO3') || die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(static function () {
    ExtensionManagementUtility::registerPageTSConfigFile(
        'powermail_limits',
        'Configuration/TsConfig/Page/AddFlexForm.tsconfig',
        'EXT:powermail_limits - add flexform options'
    );
})();
