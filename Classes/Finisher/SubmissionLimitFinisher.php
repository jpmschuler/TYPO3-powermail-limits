<?php

namespace Jpmschuler\PowermailLimits\Finisher;

use In2code\Powermail\Finisher\AbstractFinisher;

/**
 * Class DoSomethingFinisher
 */
class SubmissionLimitFinisher extends AbstractFinisher
{
    public function checkSubmissionLimitFinisher(): void
    {
        $mail = $this->getMail();
        $form = $mail->getForm();
        if ($form->isNewSubmissionForWaitlist()) {
            $this->addOnlyWaitingListWarningToAnswerPage();
            $this->addOnlyWaitingListWarningToMail();
        } elseif ($form->isNewSubmissionValid()) {
        } else {
            $this->addNoSlotWarningToAnswerPage();
            $this->addNoSlotWarningToMail();
        }

        if ($form->isLastSubmissionAllowed()) {
            die('mail to editor for list full not implemented');
        }
    }

    public function addNoSlotWarningToAnswerPage()
    {
    }

    public function addNoSlotWarningToMail()
    {
        $mail = $this->getMail();
        $subjectPrefix = 'No Slot available - ';
        $subject = $mail->getSubject();
        $mail->setSubject($subjectPrefix . $subject);
        $body = '<p>Attention: no slot available. We received your registration, however the last slot was already taken and there is no waiting list.</p>';
        $mail->setSubject($body);
    }

    public function addOnlyWaitingListWarningToAnswerPage()
    {
    }

    public function addOnlyWaitingListWarningToMail()
    {
        $mail = $this->getMail();
        $subjectPrefix = 'Only Waiting List - ';
        $subject = $mail->getSubject();
        $mail->setSubject($subjectPrefix . $subject);
        $bodyPrefix = '<p>Attention: registration for waiting list only</p>';
        $body = $mail->getSubject();
        $mail->setSubject($bodyPrefix . $body);
    }
}
