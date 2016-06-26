<?php
namespace Domain\Feedback\Service;

use Domain\Feedback\Entity\FeedbackResponse;
use Domain\Feedback\Middleware\Parameters\CreateFeedbackResponseParameters;
use Domain\Feedback\Repository\FeedbackResponseRepository;

class FeedbackResponseService
{
    /** @var FeedbackResponseRepository */
    protected $feedbackResponseRepository;

    public function __construct(FeedbackResponseRepository $feedbackResponseRepository)
    {
        $this->feedbackResponseRepository = $feedbackResponseRepository;
    }

    public function createFeedbackResponse(CreateFeedbackResponseParameters $createFeedbackResponseParameters):FeedbackResponse
    {
        return $this->feedbackResponseRepository->createFeedbackResponse($createFeedbackResponseParameters);
    }
}