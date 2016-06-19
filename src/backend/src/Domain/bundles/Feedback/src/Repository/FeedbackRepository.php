<?php
namespace Domain\Feedback\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Middleware\Parameters\CreateFeedbackParameters;

class FeedbackRepository extends EntityRepository
{
  public function createFeedback(CreateFeedbackParameters $createFeedbackParameters):Feedback
  {
    $em = $this->getEntityManager();

    $profile = null;
    if($createFeedbackParameters->hasProfile()){
      $profile = $em->getRepository(Feedback::class)->find($createFeedbackParameters->getProfileId());
    }

    $feedback = new Feedback();
    $feedback->setDescription($createFeedbackParameters->getDescription())
      ->setProfile($profile)
      ->setCreatedAt($createFeedbackParameters->getCreatedAt())
      ->setType($createFeedbackParameters->getType());



    $em->persist($feedback);
    $em->flush([$feedback]);

    return $feedback;
  }
}