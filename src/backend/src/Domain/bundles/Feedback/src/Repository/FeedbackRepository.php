<?php
namespace Domain\Feedback\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Entity\FeedbackResponse;
use Domain\Feedback\Exception\FeedbackNotFoundException;
use Domain\Feedback\Middleware\Parameters\CreateFeedbackParameters;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Exception\ProfileNotFoundException;

class FeedbackRepository extends EntityRepository
{
  public function createFeedback(CreateFeedbackParameters $createFeedbackParameters):Feedback
  {
    $em = $this->getEntityManager();

    $profile = null;
    if($createFeedbackParameters->hasProfile()){
      $profile = $em->getRepository(Profile::class)->find($createFeedbackParameters->getProfileId());
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

  public function getFeedbacksWithoutResponses()
  {
    $qb = $this->getEntityManager()->createQueryBuilder()
               ->select('f','r')
               ->from(Feedback::class, 'f')
               ->leftJoin('f.responses ', 'r')
      ->where('r.feedback IS NULL')
    ;

    return $qb->getQuery()->getResult();
  }

  public function deleteFeedback(int $feedbackId):bool
  {
    $em = $this->getEntityManager();
    /** @var Feedback $feedback */
    $feedback = $em->getRepository(Feedback::class)->find($feedbackId);
    if(is_null($feedback)){
      throw new FeedbackNotFoundException(sprintf("Feedback: %s not found",$feedbackId));
    }
    $em->remove($feedback);
    $em->flush();
    return true;
  }

  public function getAllFeedbacks(int $profileId,int $limit, int $offset):array
  {
    $profile = $this->getEntityManager()->getRepository(Profile::class)->find($profileId);
    if(is_null($profile)) throw new ProfileNotFoundException("Profile {$profileId} not found ");

    return $this->findBy(['profile' => $profile], null, $limit, $offset);
  }
}