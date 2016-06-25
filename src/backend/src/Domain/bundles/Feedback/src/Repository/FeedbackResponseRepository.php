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

    $em = $this->getEntityManager();
    /** @var Feedback $feedback */
    $feedback = $em->getRepository(Feedback::class)->find($feedbackId);
    if(is_null($feedback)){
      throw new FeedbackNotFoundException(sprintf("Feedback: %s not found",$feedbackId));
    }

    return $this->findBy(['feedback'=> $feedbackId]);

  }

  public function createFeedbackResponse(CreateFeedbackResponseParameters  $createFeedbackResponseParameters):FeedbackResponse
  {
    $em = $this->getEntityManager();
    /** @var Feedback $feedback */
    $feedback = $em->getRepository(Feedback::class)->find($createFeedbackResponseParameters->getFeedbackId());
    if(is_null($feedback)){
      throw new FeedbackNotFoundException(
        sprintf("feedback %s not found",
                $createFeedbackResponseParameters->getFeedbackId()
                ));
    }

    $createFeedbackResponseParameters->getFeedbackId();
    $feedbackResponse = new FeedbackResponse();
    $feedbackResponse
      ->setFeedback($feedback)
      ->setCreatedAt($createFeedbackResponseParameters->getCreatedAt())
      ->setDescription($createFeedbackResponseParameters->getDescription());

    $em->persist($feedbackResponse);
    $em->flush();

    return $feedbackResponse;
  }
}