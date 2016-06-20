<?php
namespace Domain\Feedback\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Middleware\Parameters\CreateFeedbackParameters;
use Domain\Profile\Exception\ProfileNotFoundException;

class FeedbackRepository extends EntityRepository
{
  public function createFeedback(CreateFeedbackParameters $createFeedbackParameters):Feedback
  {
    $em = $this->getEntityManager();

    $profile = null;
    if($createFeedbackParameters->hasProfile()){
      $profile = $em->getRepository(Feedback::class)->find($createFeedbackParameters->getProfileId());
      if(is_null($profile)) throw new ProfileNotFoundException("Profile {$createFeedbackParameters->getProfileId()} not found ");
    }

    $feedback = new Feedback();
    $feedback->setDescription($createFeedbackParameters->getDescription())
      ->setProfile($profile)
      ->setCreatedAt($createFeedbackParameters->getCreatedAt())
      ->setType($createFeedbackParameters->getType());

    $em->persist($feedback);
    $em->flush();
    return $feedback;
  }
}