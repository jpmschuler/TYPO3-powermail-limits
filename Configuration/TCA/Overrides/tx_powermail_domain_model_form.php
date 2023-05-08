<?php

defined('TYPO3') || die();

$formsTca = [
    'submissionlimit' => [
        'exclude' => false,
        'label' => 'LLL:EXT:powermail_limits/Resources/Private/Language/locallang.xlf:tca.submissionlimit',
        'description' => 'LLL:EXT:powermail_limits/Resources/Private/Language/locallang.xlf:tca.submissionlimit.description',
        'config' => [
            'type' => 'input',
            'size' => 5,
            'eval' => 'num,null',
            'mode' => 'useOrOverridePlaceholder',
        ],
    ],
    'haswaitlist' => [
        'exclude' => false,
        'label' => 'LLL:EXT:powermail_limits/Resources/Private/Language/locallang.xlf:tca.haswaitlist',
        'description' => 'LLL:EXT:powermail_limits/Resources/Private/Language/locallang.xlf:tca.haswaitlist.description',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'items' => [
                [
                    0 => ''
                ],
            ],
        ],
    ],
    'showsubmissionsfullpercentage' => [
        'exclude' => false,
        'label' => 'LLL:EXT:powermail_limits/Resources/Private/Language/locallang.xlf:tca.showsubmissionsfullpercentage',
        'description' => 'LLL:EXT:powermail_limits/Resources/Private/Language/locallang.xlf:tca.showsubmissionsfullpercentage.description',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
            'items' => [
                [
                    0 => ''
                ],
            ],
        ],
    ],

];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_powermail_domain_model_form', $formsTca);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToAllPalettesOfField('tx_powermail_domain_model_form', 'title', 'submissionlimit,haswaitlist,showsubmissionsfullpercentage', 'after:title');
