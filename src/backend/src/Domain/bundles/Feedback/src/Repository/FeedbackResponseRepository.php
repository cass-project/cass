<?php

namespace Domain\Feedback\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Entity\FeedbackResponse;
use Domain\Feedback\Exception\FeedbackNotFoundException;
use Domain\Feedback\Middleware\Parameters\CreateFeedbackResponseParameters;

class FeedbackResponseRepository extends EntityRepository
{
    public function getFeedbackResponses(int $feedbackId):array
    {
        return $this->findBy(['feedback' => $this->getFeedbackById($feedbackId)]);
    }

    public function getFeedbackById(int $feedbackId): Feedback
    {
        $feedback = $this->getEntityManager()->getRepository(Feedback::class)->find($feedbackId);

        if(is_null($feedback)) {
            throw new FeedbackNotFoundException(sprintf("Feedback: %s not found", $feedbackId));
        }

        return $feedback;
    }

    public function createFeedbackResponse(CreateFeedbackResponseParameters $createFeedbackResponseParameters):FeedbackResponse
    {
        $feedback = $this->getFeedbackById($createFeedbackResponseParameters->getFeedbackId());
        
        $createFeedbackResponseParameters->getFeedbackId();
        $feedbackResponse = new FeedbackResponse();
        $feedbackResponse
            ->setFeedback($feedback)
            ->setCreatedAt($createFeedbackResponseParameters->getCreatedAt())
            ->setDescription($createFeedbackResponseParameters->getDescription());

        $em = $this->getEntityManager();
        $em->persist($feedbackResponse);
        $em->flush();

        return $feedbackResponse;
    }
}