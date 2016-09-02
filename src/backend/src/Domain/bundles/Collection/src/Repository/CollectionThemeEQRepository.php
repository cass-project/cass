<?php
namespace CASS\Domain\Collection\Repository;

use Doctrine\ORM\EntityRepository;
use CASS\Domain\Collection\Entity\CollectionThemeEQEntity;

final class CollectionThemeEQRepository extends EntityRepository
{
    public function saveEQ(array $entities)
    {
        foreach($entities as $entity) {
            $this->getEntityManager()->persist($entity);
        }

        $this->getEntityManager()->flush($entities);
    }

    public function sync(int $collectionId, array $themeIds)
    {
        $this->deleteEQOfCollection($collectionId);
        $this->saveEQ(array_map(function(int $themeId) use ($collectionId) {
            return new CollectionThemeEQEntity($collectionId, $themeId);
        }, $themeIds));
    }

    public function deleteEQOfCollection(int $collectionId)
    {
        $em = $this->getEntityManager();

        $em->flush(array_map(function(CollectionThemeEQEntity $eq) use ($em) {
            $em->remove($eq);

            return $eq;
        }, $this->findBy([
            'collectionId' => $collectionId
        ])));
    }

    public function deleteEQOfTheme(int $themeId)
    {
        $em = $this->getEntityManager();

        $em->flush(array_map(function(CollectionThemeEQEntity $eq) use ($em) {
            $em->remove($eq);

            return $eq;
        }, $this->findBy([
            'themeId' => $themeId
        ])));
    }

    public function getCollectionsByThemeId(int $themeId): array
    {
        /** @var CollectionThemeEQEntity[] $result */
        $result = $this->findBy([
            'themeId' => $themeId
        ]);

        return $result;
    }
}