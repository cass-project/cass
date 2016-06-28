<?php
namespace Domain\Feedback\Service;

use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\FeedbackType\FeedbackTypeFactory;
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

    /** @var FeedbackTypeFactory */
    private $feedbackTypeFactory;

    public function __construct(
        ProfileService $profileService,
        FeedbackRepository $feedbackRepository,
        FeedbackResponseRepository $feedbackResponseRepository,
        FeedbackTypeFactory $feedbackTypeFactory
    ) {
        $this->profileService = $profileService;
        $this->feedbackRepository = $feedbackRepository;
        $this->feedbackResponseRepository = $feedbackResponseRepository;
        $this->feedbackTypeFactory = $feedbackTypeFactory;
    }

    public function createFeedback(CreateFeedbackParameters $createFeedbackParameters): Feedback
    {
        $feedback = new Feedback(
            $this->feedbackTypeFactory->createFromIntCode($createFeedbackParameters->getType()),
            $createFeedbackParameters->getDescription()
        );

        if($createFeedbackParameters->hasProfile()) {
            $profile = $this->profileService->getProfileById($createFeedbackParameters->getProfileId());
            $feedback->setProfile($profile);
        }else{
            if($createFeedbackParameters->hasEmail()) {
                $feedback->setEmail($createFeedbackParameters->getEmail());
            }
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

    public function getFeedbackEntities(int $profileId, array $options): array
    {
        return $this->feedbackRepository->getAllFeedbackEntities($profileId, $options);
    }
    
    public function getFeedbackResponse(int $feedbackId): array
    {
        return $this->feedbackResponseRepository->getFeedbackResponses($feedbackId);
    }
}