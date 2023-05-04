<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

/**
 * Include TypoScript
 */
// @extensionScannerIgnoreLine seems to be a false positive
ExtensionManagementUtility::addStaticFile(
    'powermail_limits',
    'Configuration/TypoScript',
    'SubmissionLimits for EXT:powermail'
);
