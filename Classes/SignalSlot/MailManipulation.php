<?php

namespace Jpmschuler\PowermailLimits\SignalSlot;

use In2code\Powermail\Domain\Service\Mail\SendMailService;
use Jpmschuler\PowermailLimits\Domain\Model\FormWithSubmissionLimit;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class MailManipulation
{
    /**
     * @param array<string, mixed> $email
     */
    public function sendTemplateEmailBeforeSend(
        MailMessage $message,
        array $email,
        SendMailService $originalService
    ): void {
        /** @var FormWithSubmissionLimit $form */
        $form = $originalService->getMail()->getForm();
        if ($form->isNewSubmissionForWaitlistMailManipulation()) {
            $subjectPrefix = LocalizationUtility::translate(
                'mail.waitinglistsubmission.subjectprefix',
                'PowermailLimits'
            );
            $subject = $subjectPrefix . $message->getSubject();
            $message->setSubject($subject);
        } elseif (!$form->isNewSubmissionValid()) {
            $subjectPrefix = LocalizationUtility::translate(
                'mail.invalidsubmission.subjectprefix',
                'PowermailLimits'
            );
            $subject = $subjectPrefix . $message->getSubject();
            $message->setSubject($subject);
        }
    }

    /**
     * @param array<string, mixed> $email
     */
    public function createEmailBodyBeforeRender(
        StandaloneView $standaloneView,
        array $email,
        SendMailService $originalService
    ): void {
        /** @var FormWithSubmissionLimit $form */
        $form = $originalService->getMail()->getForm();
        $isReceiverMail = $email['template'] == 'Mail/ReceiverMail';

        if ($form->isNewSubmissionForWaitlistMailManipulation()) {
            $bodyPrefixHeader = LocalizationUtility::translate(
                'mail.waitinglistsubmission.bodyprefix.header',
                'PowermailLimits'
            );
            $bodyPrefixText = LocalizationUtility::translate(
                'mail.waitinglistsubmission.bodyprefix.text',
                'PowermailLimits'
            );
            $bodyPrefix = sprintf('<p><strong>%s</strong></p><p>%s</p><hr>', $bodyPrefixHeader, $bodyPrefixText);
            $email['rteBody'] = $bodyPrefix . $email['rteBody'];
            $standaloneView->assign('powermail_rte', $email['rteBody']);
        } elseif (!$form->isNewSubmissionValid()) {
            $bodyPrefixHeader = LocalizationUtility::translate(
                'mail.invalidsubmission.bodyprefix.header',
                'PowermailLimits'
            );
            $bodyPrefixText = LocalizationUtility::translate(
                'mail.invalidsubmission.bodyprefix.text',
                'PowermailLimits'
            );
            $bodyPrefix = sprintf('<p><strong>%s</strong></p><p>%s</p><hr>', $bodyPrefixHeader, $bodyPrefixText);
            $email['rteBody'] = $bodyPrefix . $email['rteBody'];
            $standaloneView->assign('powermail_rte', $email['rteBody']);
        }
    }
}
