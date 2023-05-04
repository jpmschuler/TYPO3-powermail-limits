<?php

use In2code\Powermail\Domain\Service\Mail\SendMailService;
use Jpmschuler\PowermailLimits\SignalSlot\MailManipulation;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\Container\Container::class)
    ->registerImplementation(\In2code\Powermail\Domain\Model\Form::class, \Jpmschuler\PowermailLimits\Domain\Model\FormWithSubmissionLimit::class);

$signalSlotDispatcher = GeneralUtility::makeInstance(
    Dispatcher::class
);

$signalSlotDispatcher->connect(
    SendMailService::class,
    'sendTemplateEmailBeforeSend',
    MailManipulation::class,
    'sendTemplateEmailBeforeSend',
    false
);
// add the PDF download link to the Admin E-Mail
$signalSlotDispatcher->connect(
    SendMailService::class,
    'createEmailBodyBeforeRender',
    MailManipulation::class,
    'createEmailBodyBeforeRender',
    false
);
