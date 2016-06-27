<?php
namespace Domain\Feedback\Service;

use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Middleware\Parameters\CreateFeedbackParameters;
use Domain\Feedback\Repository\FeedbackRepository;
use Domain\Feedback\Repository\FeedbackResponseRepository;
use Domain\Profile\Service\ProfileService;

class FeedbackService
{
    /** @var ProfileService */
    private $profileService;

    /** @var FeedbackRepository $feedbackRepository */
    private $feedbackRepository;

    /** @var FeedbackResponseRepository $feedbackResponseRepository */
    private $feedbackResponseRepository;

    public function __construct(
        ProfileService $profileService,
        FeedbackRepository $feedbackRepository,
        FeedbackResponseRepository $feedbackResponseRepository
    ) {
        $this->profileService = $profileService;
        $this->feedbackRepository = $feedbackRepository;
        $this->feedbackResponseRepository = $feedbackResponseRepository;
    }

    public function createFeedback(CreateFeedbackParameters $createFeedbackParameters): Feedback
    {
        $feedback = new Feedback();
        $feedback
            ->setDescription($createFeedbackParameters->getDescription())
            ->setType($createFeedbackParameters->getType());
        ;

        if($createFeedbackParameters->hasProfile()) {
            $feedback->setProfile($this->profileService->getProfileById($createFeedbackParameters->getProfileId()));
        }

        $this->feedbackRepository->createFeedback($feedback);

        return $feedback;
    }

    public function deleteFeedback(int $feedbackId): Feedback
    {
        return $this->feedbackRepository->deleteFeedback(
            $this->feedbackRepository->getFeedbackById($feedbackId)
        );
    }

    public function getFeedbackEntitiesWithoutResponses(): array
    {
        return $this->feedbackRepository->getFeedbackEntitiesWithoutResponses();
    }

    public function getFeedbackResponse(int $feedbackId): array
    {
        return $this->feedbackResponseRepository->getFeedbackResponses($feedbackId);
    }

    public function getAllFeedbackEntities(int $profileId, int $limit, int $offset): array
    {
        return $this->feedbackRepository->getAllFeedbackEntities($profileId, $limit, $offset);
    }
}