<?php
namespace Domain\Feedback\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Exception\FeedbackNotFoundException;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Exception\ProfileNotFoundException;

class FeedbackRepository extends EntityRepository
{
    public function createFeedback(Feedback $feedback)
    {
        $em = $this->getEntityManager();
        $em->persist($feedback);
        $em->flush($feedback);
    }

    public function saveFeedback(Feedback $feedback): Feedback
    {
        $this->getEntityManager()->flush([$feedback]);

        return $feedback;
    }

    public function getFeedbackById(int $feedbackId): Feedback
    {
        $feedback = $this->find($feedbackId);

        if($feedback === null) {
            throw new FeedbackNotFoundException(sprintf('Feedback(ID: %s) not found', $feedbackId));
        }

        return $feedback;
    }

    public function getFeedbackEntitiesWithoutResponses()
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('f', 'r')
            ->from(Feedback::class, 'f')
            ->leftJoin('f.responses ', 'r')
            ->where('r.feedback IS NULL');

        return $qb->getQuery()->getResult();
    }

    public function deleteFeedback(Feedback $feedback): Feedback
    {
        $em = $this->getEntityManager();
        $em->remove($feedback);
        $em->flush($feedback);

        return $feedback;
    }

    public function getAllFeedbackEntities(int $profileId, int $limit, int $offset): array
    {
        $profile = $this->getEntityManager()->getRepository(Profile::class)->find($profileId);
        if(is_null($profile)) throw new ProfileNotFoundException("Profile {$profileId} not found ");

        return $this->findBy([
            'profile' => $profile
        ], null, $limit, $offset);
    }
}