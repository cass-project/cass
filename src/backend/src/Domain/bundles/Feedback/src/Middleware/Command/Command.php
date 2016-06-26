<?php
namespace Domain\Feedback\Middleware\Command;

use Application\Command\Command as CommandInterface;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Feedback\Service\FeedbackResponseService;
use Domain\Feedback\Service\FeedbackService;

abstract class Command implements CommandInterface
{
    /** @var FeedbackService $feedbackService */
    protected $feedbackService;

    /** @var FeedbackResponseService */
    protected $feedbackResponseService;

    /** @var CurrentAccountService $currentAccountService */
    protected $currentAccountService;

    public function __construct(
        FeedbackService $feedbackService,
        FeedbackResponseService $feedbackResponseService,
        CurrentAccountService $currentAccountService
    ) {
        $this->feedbackService = $feedbackService;
        $this->feedbackResponseService = $feedbackResponseService;
        $this->currentAccountService = $currentAccountService;
    }
}