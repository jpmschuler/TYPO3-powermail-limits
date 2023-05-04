<?php

declare(strict_types=1);

namespace Jpmschuler\PowermailLimits\Domain\Model;

use In2code\Powermail\Domain\Model\Form;
use In2code\Powermail\Domain\Repository\MailRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class Form
 */
class FormWithSubmissionLimit extends Form
{
    public ?int $submissionlimit = null;
    public int $haswaitlist = 0;
    public int $showsubmissionsfullpercentage = 0;

    public function hasWaitList(): bool
    {
        return (bool)$this->haswaitlist;
    }

    public function getCurrentsubmissions(): int
    {
        $mailRepository = GeneralUtility::makeInstance(MailRepository::class);
        $query = $mailRepository->createQuery();
        return $query->matching($query->equals('form', $this->getUid()))->count();
    }

    public function getRegularsubmissionspossible(): bool
    {
        if ($this->submissionlimit == 0) {
            return true;
        }
        if ($this->getCurrentsubmissions() >= $this->submissionlimit) {
            return false;
        }
        return true;
    }

    public function getSubmissionsfullpercentage(): int
    {
        if ($this->submissionlimit && $this->submissionlimit > 0) {
            $limit = $this->getCurrentsubmissions() / $this->submissionlimit;
            return (int)(floor($limit * 10) * 10);
        }
        return 0;
    }

    public function getWaitlistsubmissionpossible(): bool
    {
        if ($this->getRegularsubmissionspossible()) {
            return false;
        }
        if ($this->haswaitlist) {
            return true;
        }
        return false;
    }

    public function isNewSubmissionForWaitlistProcessor(): bool
    {
        if ($this->submissionlimit) {
            // check for +1 because in DataProcessor we didn't save the mail yet
            if (($this->getCurrentsubmissions() + 1) > $this->submissionlimit) {
                if ($this->haswaitlist) {
                    return true;
                }
            }
        }
        return false;
    }

    public function isNewSubmissionForWaitlistMailManipulation(): bool
    {
        if ($this->submissionlimit) {
            // check for +0 because in Mailmanipulation we did save the mail
            if (($this->getCurrentsubmissions()) > $this->submissionlimit) {
                if ($this->haswaitlist) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @return bool true, if either normal submission or waiting list submission
     */
    public function isNewSubmissionValid(): bool
    {
        if ($this->submissionlimit) {
            if ($this->getCurrentsubmissions() > $this->submissionlimit) {
                if ($this->haswaitlist) {
                    return true;
                }
                return false;
            }
        }
        return true;
    }

    public function isLastSubmissionAllowed(): bool
    {
        if ($this->submissionlimit) {
            if ($this->getCurrentsubmissions() == $this->submissionlimit) {
                return true;
            }
        }
        return false;
    }
}
