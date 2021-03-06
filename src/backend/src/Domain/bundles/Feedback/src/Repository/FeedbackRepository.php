<?php
namespace CASS\Domain\Bundles\Feedback\Repository;

use CASS\Util\Seek;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use CASS\Domain\Bundles\Feedback\Entity\Feedback;
use CASS\Domain\Bundles\Feedback\Exception\FeedbackNotFoundException;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;

class FeedbackRepository extends EntityRepository
{
    const DEFAULT_LIMIT = 50;
    const MAX_LIMIT = 200;

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

    public function getFeedbackEntities(array $options): array
    {
        $options = array_merge([
            'profileId' => null,
            'seek' => [
                'offset' => 0,
                'limit' => self::DEFAULT_LIMIT
            ],
            'filter' => [
                'read' => null,
                'answer' => null
            ]
        ], $options);

        $seek = new Seek(self::MAX_LIMIT, $options['seek']['offset'], $options['seek']['limit']);

        $qb = $this->createQueryBuilder('f');
        $qb->setFirstResult($seek->getOffset());
        $qb->setMaxResults($seek->getLimit());

        if($options['profileId']) {
            $qb->andWhere($qb->expr()->eq('f.profile', (int) $options['profileId']));
        }

        if(isset($options['filter']['read'])) {
            $qb->andWhere($qb->expr()->eq('f.read', (int) $options['filter']['read']));
        }

        if(isset($options['filter']['answer'])) {
            if($options['filter']['answer']) {
                $qb->andWhere('f.response IS NOT NULL');
            }else{
                $qb->andWhere('f.response IS NULL');
            }
        }

        return $qb->getQuery()->execute();
    }
}