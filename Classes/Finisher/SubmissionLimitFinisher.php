<?php

namespace Jpmschuler\PowermailLimits\Finisher;

use In2code\Powermail\Finisher\AbstractFinisher;
use Jpmschuler\PowermailLimits\Domain\Model\FormWithSubmissionLimit;
use Symfony\Component\Mime\Address;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class DoSomethingFinisher
 */
class SubmissionLimitFinisher extends AbstractFinisher
{
    public function checkSubmissionLimitFinisher(): void
    {
        $mail = $this->getMail();
        /** @var FormWithSubmissionLimit $form */
        $form = $mail->getForm();

        if ($form->isLastSubmissionAllowed()) {
            $recipient = new Address($mail->getReceiverMail());
            $subject = sprintf(
                LocalizationUtility::translate('mail.submissionlimitreached.subject', 'powermail_limits'),
                $form->getTitle()
            );
            $body = sprintf(
                LocalizationUtility::translate('mail.submissionlimitreached.body', 'powermail_limits'),
                $form->getTitle()
            );

            $emailLimitReached = GeneralUtility::makeInstance(MailMessage::class);
            $emailLimitReached
                ->from($recipient)
                ->to($recipient)
                ->subject($subject)
                ->text($body)
                ->send();
        }
    }
}
