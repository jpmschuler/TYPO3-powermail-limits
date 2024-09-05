<?php

namespace Jpmschuler\PowermailLimits\EventListener;

use In2code\Powermail\Events\SendMailServicePrepareAndSendEvent;
use Jpmschuler\PowermailLimits\Domain\Model\FormWithSubmissionLimit;
use Jpmschuler\PowermailLimits\Service\PowerMailLimitsService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
final class AddSubjectPrefixToMail
{
    public function __construct(
        private readonly PowerMailLimitsService $powerMailLimitsService
    ) {
    }

    public function __invoke(SendMailServicePrepareAndSendEvent $event): void
    {
        $originalService = $event->getSendMailService();
        $message = $event->getMailMessage();

        $form = $originalService->getMail()->getForm();

        if (!$form instanceof FormWithSubmissionLimit) {
            return;
        }

        $this->powerMailLimitsService->addSubjectPrefixToMail($form, $message);
    }
}
