<?php

namespace Jpmschuler\PowermailLimits\DataProcessor;

use In2code\Powermail\DataProcessor\AbstractDataProcessor;
use In2code\Powermail\Domain\Model\Answer;
use In2code\Powermail\Domain\Model\Field;
use Jpmschuler\PowermailLimits\Domain\Model\FormWithSubmissionLimit;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class SubmissionLimitDataProcessor extends AbstractDataProcessor
{
    /**
     * @param array<string, mixed> $newData
     */
    protected function addNewValuesToMail(array $newData): void
    {
        foreach ($newData as $label => $data) {
            $answer = new Answer();
            $answer->_setProperty('translateFormat', 'Y-m-d');
            $answer->_setProperty('valueType', 0);
            $field = new Field();
            $field->setType('input');
            $field->setTitle($label);
            $answer->_setProperty('name', $label);
            $answer->_setProperty('value', $data);
            $answer->setValueType(0);
            $answer->setField($field);
            $this->getMail()->addAnswer($answer);
        }
    }

    public function addFieldsDataProcessor(): void
    {
        $mail = $this->getMail();
        /** @var FormWithSubmissionLimit $form */
        $form = $mail->getForm();

        if ($form->submissionlimit) {
            $addToOutput = [];

            $labelSubmissionLimit = LocalizationUtility::translate(
                'form.submissionstatus',
                'powermail_limits'
            );

            if ($form->isNewSubmissionForWaitlistProcessor()) {
                $addToOutput[$labelSubmissionLimit] = LocalizationUtility::translate(
                    'form.submissionstatus.waitinglist',
                    'powermail_limits'
                );

                $subjectPrefix = LocalizationUtility::translate(
                    'mail.waitinglistsubmission.subjectprefix',
                    'powermail_limits'
                );
                $subject = $subjectPrefix . $mail->getSubject();
                $mail->setSubject($subject);
            } elseif ($form->isNewSubmissionValid()) {
                $addToOutput[$labelSubmissionLimit] = LocalizationUtility::translate(
                    'form.submissionstatus.valid',
                    'powermail_limits'
                );
            } else {
                $addToOutput[$labelSubmissionLimit] = LocalizationUtility::translate(
                    'form.submissionstatus.invalid',
                    'powermail_limits'
                );
                $mail->setHidden(true);
            }
            $this->addNewValuesToMail($addToOutput);
        }
    }
}
