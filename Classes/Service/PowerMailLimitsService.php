<?php

namespace Jpmschuler\PowermailLimits\Service;

use Jpmschuler\PowermailLimits\Domain\Model\FormWithSubmissionLimit;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class PowerMailLimitsService
{
    const EXTENSION_KEY = 'powermail_limits';

    public function addSubjectPrefixToMail(FormWithSubmissionLimit $form, MailMessage $message): void
    {
        $subjectPrefix = '';

        if ($form->isNewSubmissionForWaitlistMailManipulation()) {
            $subjectPrefix = $this->getTranslation('mail.waitinglistsubmission.subjectprefix');
        } elseif (!$form->isNewSubmissionValid()) {
            $subjectPrefix = $this->getTranslation('mail.invalidsubmission.subjectprefix');
        }

        $subject = $subjectPrefix . $message->getSubject();
        $message->setSubject($subject);
    }

    public function addBodyPrefixHeaderAndTextToView(FormWithSubmissionLimit $form, StandaloneView $standaloneView, array $email)
    {
        $bodyPrefixHeader = '';
        $bodyPrefixText = '';

        if ($form->isNewSubmissionForWaitlistMailManipulation()) {
            $bodyPrefixHeader = $this->getTranslation('mail.waitinglistsubmission.bodyprefix.header');
            $bodyPrefixText = $this->getTranslation('mail.waitinglistsubmission.bodyprefix.text');
        } elseif (!$form->isNewSubmissionValid()) {
            $bodyPrefixHeader = $this->getTranslation('mail.invalidsubmission.bodyprefix.header');
            $bodyPrefixText = $this->getTranslation('mail.invalidsubmission.bodyprefix.text');
        }

        $bodyPrefix = sprintf('<p><strong>%s</strong></p><p>%s</p><hr>', $bodyPrefixHeader, $bodyPrefixText);
        $email['rteBody'] = $bodyPrefix . $email['rteBody'];
        $standaloneView->assign('powermail_rte', $email['rteBody']);
    }

    private function getTranslation(string $key): ?string
    {
        return LocalizationUtility::translate($key, self::EXTENSION_KEY);
    }
}
