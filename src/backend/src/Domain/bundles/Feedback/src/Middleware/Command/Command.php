<?php
namespace Domain\Feedback\Middleware\Command;

use CASS\Application\Command\Command as CommandInterface;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Feedback\Service\FeedbackService;

abstract class Command implements CommandInterface
{
    /** @var FeedbackService $feedbackService */
    protected $feedbackService;

    /** @var CurrentAccountService $currentAccountService */
    protected $currentAccountService;

    public function __construct(
        FeedbackService $feedbackService,
        CurrentAccountService $currentAccountService
    ) {
        $this->feedbackService = $feedbackService;
        $this->currentAccountService = $currentAccountService;
    }
}