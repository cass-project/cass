<?php
namespace Domain\Feedback\Middleware\Command;
use Application\Command\Command as CommandInterface;
use Application\REST\Response\ResponseBuilder;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Service\FeedbackResponseService;
use Domain\Feedback\Service\FeedbackService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command implements CommandInterface
{

  /** @var FeedbackService $feedbackService */
  protected $feedbackService;
  protected $feedbackResponseService;
  /** @var CurrentAccountService $currentAccountService */
  protected $currentAccountService;

  public function __construct(
    FeedbackService $feedbackService,
    FeedbackResponseService $feedbackResponseService,
    CurrentAccountService $currentAccountService
  )
  {
    $this->feedbackService = $feedbackService;
    $this->feedbackResponseService = $feedbackResponseService;
    $this->currentAccountService = $currentAccountService;
  }
}