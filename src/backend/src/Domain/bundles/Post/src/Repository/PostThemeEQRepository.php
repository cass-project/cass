<?php
namespace CASS\Domain\Post\Repository;

use Doctrine\ORM\EntityRepository;
use CASS\Domain\Post\Entity\PostThemeEQ;

final class PostThemeEQRepository extends EntityRepository
{
    public function setEQ(int $postId, array $themeIds): array
    {
        $this->destroyEQ($postId);

        /** @var PostThemeEQ[] $entities */
        $entities = array_map(function($themeId) use ($postId) {
            $entity = new PostThemeEQ($postId, $themeId);
            $this->getEntityManager()->persist($entity);
        }, $themeIds);

        $this->getEntityManager()->flush($entities);

        return $entities;
    }

    public function destroyEQ(int $postId)
    {
        $entities = [];

        array_map(function(PostThemeEQ $eq) use ($entities) {
            $this->getEntityManager()->remove($eq);
            $entities[] = $eq;
        }, $this->findBy([
            'postId' => $postId
        ]));

        $this->getEntityManager()->flush($entities);
    }
}