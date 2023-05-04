<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

call_user_func(function () {
    ExtensionManagementUtility::registerPageTSConfigFile(
        'powermail_limits',
        'Configuration/TsConfig/Page/AddFlexForm.tsconfig',
        'EXT:powermail_limits - add flexform options'
    );
});
