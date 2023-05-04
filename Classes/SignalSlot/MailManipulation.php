<?php

namespace Jpmschuler\PowermailLimits\SignalSlot;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class MailManipulation
{
    public function sendTemplateEmailBeforeSend($message, $email, $originalService)
    {
        $form = $originalService->getMail()->getForm();
        if ($form->isNewSubmissionForWaitlist()) {
            $subjectPrefix = LocalizationUtility::translate(
                'mail.waitinglistsubmission.subjectprefix',
                'powermail_limits'
            );
            $subject = $subjectPrefix . $message->getSubject();
            $message->setSubject($subject);
        } elseif (!$form->isNewSubmissionValid()) {
            $subjectPrefix = LocalizationUtility::translate(
                'mail.invalidsubmission.subjectprefix',
                'powermail_limits'
            );
            $subject = $subjectPrefix . $message->getSubject();
            $message->setSubject($subject);
        }
    }

    public function createEmailBodyBeforeRender($standaloneView, $email, $originalService)
    {
        $form = $originalService->getMail()->getForm();
        $isReceiverMail = $email['template'] == 'Mail/ReceiverMail';

        if ($form->isNewSubmissionForWaitlist()) {
            $bodyPrefixHeader = LocalizationUtility::translate(
                'mail.waitinglistsubmission.bodyprefix.header',
                'powermail_limits'
            );
            $bodyPrefixText = LocalizationUtility::translate(
                'mail.waitinglistsubmission.bodyprefix.text',
                'powermail_limits'
            );
            $bodyPrefix = sprintf('<p><strong>%s</strong></p><p>%s</p><hr>', $bodyPrefixHeader, $bodyPrefixText);
            $email['rteBody'] = $bodyPrefix . $email['rteBody'];
            $standaloneView->assign('powermail_rte', $email['rteBody']);
        } elseif (!$form->isNewSubmissionValid()) {
            $bodyPrefixHeader = LocalizationUtility::translate(
                'mail.invalidsubmission.bodyprefix.header',
                'powermail_limits'
            );
            $bodyPrefixText = LocalizationUtility::translate(
                'mail.invalidsubmission.bodyprefix.text',
                'powermail_limits'
            );
            $bodyPrefix = sprintf('<p><strong>%s</strong></p><p>%s</p><hr>', $bodyPrefixHeader, $bodyPrefixText);
            $email['rteBody'] = $bodyPrefix . $email['rteBody'];
            $standaloneView->assign('powermail_rte', $email['rteBody']);
        }
    }
}
