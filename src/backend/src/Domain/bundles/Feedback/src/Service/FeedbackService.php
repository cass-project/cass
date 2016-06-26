<?php
namespace Domain\Feedback\Service;

use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Middleware\Parameters\CreateFeedbackParameters;
use Domain\Feedback\Repository\FeedbackRepository;
use Domain\Feedback\Repository\FeedbackResponseRepository;

class FeedbackService
{
    /** @var FeedbackRepository $feedbackRepository */
    private $feedbackRepository;
    
    /** @var FeedbackResponseRepository $feedbackResponseRepository */
    private $feedbackResponseRepository;

    public function __construct(
        FeedbackRepository $feedbackRepository,
        FeedbackResponseRepository $feedbackResponseRepository
    )
    {
        $this->feedbackRepository = $feedbackRepository;
        $this->feedbackResponseRepository = $feedbackResponseRepository;
    }

    public function createFeedback(CreateFeedbackParameters $createFeedbackParameters):Feedback
    {
        return $this->feedbackRepository->createFeedback($createFeedbackParameters);
    }

    public function deleteFeedback(int $feedbackId):bool
    {
        return $this->feedbackRepository->deleteFeedback($feedbackId);
    }

    public function getFeedbacksWithoutResponses():array
    {
        return $this->feedbackRepository->getFeedbacksWithoutResponses();
    }

    public function getFeedbackResponse(int $feedbackId):array
    {
        return $this->feedbackResponseRepository->getFeedbackResponses($feedbackId);
    }

    public function getAllFeedbacks(int $profileId, int $limit, int $offset)
    {
        return $this->feedbackRepository->getAllFeedbacks($profileId, $limit, $offset);
    }
}