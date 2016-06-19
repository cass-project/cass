<?php
namespace Domain\Feedback\Middleware\Command;
use Application\Command\Command as CommandInterface;
use Application\REST\Response\ResponseBuilder;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Service\FeedbackService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command implements CommandInterface
{

  /** @var FeedbackService $feedbackService */
  protected $feedbackService;

  public function __construct(
    FeedbackService $feedbackService
  )
  {
    $this->feedbackService = $feedbackService;
  }
}