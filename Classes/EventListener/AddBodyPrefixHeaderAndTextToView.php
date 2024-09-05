<?php

namespace Jpmschuler\PowermailLimits\EventListener;

use In2code\Powermail\Events\SendMailServiceCreateEmailBodyEvent;
use Jpmschuler\PowermailLimits\Domain\Model\FormWithSubmissionLimit;
use Jpmschuler\PowermailLimits\Service\PowerMailLimitsService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
final class AddBodyPrefixHeaderAndTextToView
{
    public function __construct(
        private readonly PowerMailLimitsService $powerMailLimitsService,
    ) {
    }

    public function __invoke(SendMailServiceCreateEmailBodyEvent $event): void
    {
        $originalService = $event->getSendMailService();
        $standaloneView = $event->getStandaloneView();
        $email = $event->getEmail();

        $form = $originalService->getMail()->getForm();

        if (!$form instanceof FormWithSubmissionLimit) {
            return;
        }
        $this->powerMailLimitsService->addBodyPrefixHeaderAndTextToView($form, $standaloneView, $email);
    }
}
