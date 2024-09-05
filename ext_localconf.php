<?php

use In2code\Powermail\Domain\Model\Form;
use Jpmschuler\PowermailLimits\Domain\Model\FormWithSubmissionLimit;

defined('TYPO3') || die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][Form::class] = [
    'className' => FormWithSubmissionLimit::class,
];
