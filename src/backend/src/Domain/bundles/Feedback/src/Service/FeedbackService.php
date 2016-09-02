<?php
namespace CASS\Domain\Bundles\Feedback\Service;

use CASS\Domain\Bundles\Feedback\Entity\Feedback;
use CASS\Domain\Bundles\Feedback\Entity\FeedbackResponse;
use CASS\Domain\Bundles\Feedback\Exception\FeedbackHasNoAnswerException;
use CASS\Domain\Bundles\Feedback\FeedbackType\FeedbackTypeFactory;
use CASS\Domain\Bundles\Feedback\Middleware\Parameters\CreateFeedbackParameters;
use CASS\Domain\Bundles\Feedback\Middleware\Parameters\CreateFeedbackResponseParameters;
use CASS\Domain\Bundles\Feedback\Repository\FeedbackRepository;
use CASS\Domain\Bundles\Feedback\Repository\FeedbackResponseRepository;
use CASS\Domain\Bundles\Profile\Service\ProfileService;

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
            $createFeedbackParameters->getDescription(),
            $createFeedbackParameters->hasProfile()
                ? $this->profileService->getProfileById($createFeedbackParameters->getProfileId())
                : null
        );

        if(! $createFeedbackParameters->hasProfile()) {
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

    public function markAsRead(int $feedbackId): Feedback
    {
        $feedback = $this->feedbackRepository->getFeedbackById($feedbackId);

        if(! $feedback->hasResponse()) {
            throw new FeedbackHasNoAnswerException(sprintf('Feedback (ID: %s) has no response', $feedbackId));
        }

        $feedback->markAsRead();
        $this->feedbackRepository->saveFeedback($feedback);

        return $feedback;
    }
    
    public function answer(CreateFeedbackResponseParameters $parameters): FeedbackResponse
    {
        $feedback = $this->getFeedbackById($parameters->getFeedbackId());
        
        $feedbackResponse = new FeedbackResponse($feedback);
        $feedbackResponse->setDescription($parameters->getDescription());

        $feedback->specifyResponse($feedbackResponse);

        $this->feedbackRepository->saveFeedback($feedback);

        return $feedbackResponse;
    }

    public function getFeedbackById(int $feedbackId): Feedback
    {
        return $this->feedbackRepository->getFeedbackById($feedbackId);
    }

    public function getFeedbackEntities(array $options): array
    {
        return $this->feedbackRepository->getFeedbackEntities($options);
    }
    
    public function getFeedbackResponse(int $feedbackId): array
    {
        return $this->feedbackResponseRepository->getFeedbackResponses($feedbackId);
    }
}