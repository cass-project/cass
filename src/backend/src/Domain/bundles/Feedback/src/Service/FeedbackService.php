<?php


namespace Domain\Feedback\Service;


use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Middleware\Parameters\CreateFeedbackParameters;
use Domain\Feedback\Repository\FeedbackRepository;

class FeedbackService
{

  /** @var FeedbackRepository $feedbackRepository */
  private $feedbackRepository;

  public function __construct(FeedbackRepository $feedbackRepository)
  {
    $this->feedbackRepository = $feedbackRepository;
  }

  public function createFeedback(CreateFeedbackParameters $createFeedbackParameters):Feedback
  {
    return $this->feedbackRepository->createFeedback($createFeedbackParameters);
  }

}