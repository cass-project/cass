<?php
namespace Domain\Collection\Repository;

use Domain\Collection\Entity\Collection;
use Domain\Collection\Service\Parameters\CollectionService\CollectionCreateParameters;
use Domain\Collection\Service\Parameters\CollectionService\CollectionDeleteParameters;
use Domain\Collection\Service\Parameters\CollectionService\CollectionMoveParameters;
use Domain\Collection\Service\Parameters\CollectionService\CollectionParameters;
use Domain\Collection\Service\Parameters\CollectionService\CollectionUpdateParameters;
use Application\Exception\EntityNotFoundException;
use Application\Util\SerialManager\SerialManager;
use Doctrine\ORM\EntityRepository;
use Domain\Profile\Entity\Profile;

class CollectionRepository extends EntityRepository
{
    public function getCollections($params): array
    {
        return $this->findBy($params);
    }

    public function getRootCollections(int $profileId)
    {
        return $this->findBy([
            'parent' => null,
            'profile' => $profileId
        ], ['position' => 'asc']);
    }

    public function getCollectionsAsTree(/** @var $collections Collection[] */array $collections, int $parentId = null, $depth = 0): array
    {
        $tree = [];

        foreach($collections as $collection) {
            if($collection->getParentId() === $parentId) {
                if($collection->hasChildren()) {
                    $children = $this->getCollectionsAsTree($collections, $collection->getId(), $depth + 1);
                }else{
                    $children = [];
                }

                $tree[] = array_merge($collection->toJSON(), [
                    'children' =>  $children,
                    'depth' => $depth
                ]);
            }
        }

        return $tree;
    }

    public function create(Profile $profile, CollectionCreateParameters $collectionCreateParameters): Collection
    {
        $collectionEntity = new Collection($profile);

        $this->setupEntity($collectionEntity, $collectionCreateParameters);

        $em = $this->getEntityManager();
        $em->persist($collectionEntity);
        $em->flush();

        return $collectionEntity;
    }

    public function update(CollectionUpdateParameters $collectionUpdateParameters): Collection
    {
        $themeEntity = $this->getCollectionEntity($collectionUpdateParameters->getId());

        $this->setupEntity($themeEntity, $collectionUpdateParameters);

        $em = $this->getEntityManager();
        $em->persist($themeEntity);
        $em->flush();

        return $themeEntity;
    }

    public function delete(CollectionDeleteParameters $collectionDeleteParameters): Collection
    {
        $collectionEntity = $this->getCollectionEntity($collectionDeleteParameters->getCollectionId());

        $parentId = $collectionEntity->hasParent() ? $collectionEntity->getParent()->getId() : null;
        $siblings = new SerialManager($this->getCollectionsWithParent($parentId));

        $siblings->remove($collectionEntity);

        $em = $this->getEntityManager();
        $em->remove($collectionEntity);
        $em->flush();

        return $collectionEntity;
    }

    public function move(CollectionMoveParameters $collectionMoveParameters): Collection
    {
        $em = $this->getEntityManager();
        $collectionEntity = $this->getCollectionEntity($collectionMoveParameters->getCollectionId());

        $parentId = $collectionMoveParameters->getMoveToParentCollectionId();

        if($parentId == 0) {
            $collectionEntity->setParent(null);
        }else{
            $collectionEntity->setParent($em->getReference(Collection::class, $parentId));
        }

        $siblings = new SerialManager($this->getCollectionsWithParent($collectionMoveParameters->getMoveToParentCollectionId()));
        $siblings->insertAs($collectionEntity, $collectionMoveParameters->getMoveToPosition());

        $em->persist($collectionEntity);
        $em->flush();

        return $collectionEntity;
    }

    private function setupEntity(Collection $collectionEntity, CollectionParameters $collectionParameters)
    {
        $em = $this->getEntityManager();

        $collectionParameters->getTitle()->on([$collectionEntity, "setTitle"]);
        $collectionParameters->getDescription()->on([$collectionEntity, "setDescription"]);

        $collectionParameters->getParentId()->on(function($value) use ($collectionEntity, $em, &$parentId) {
            if($value > 0) {
                $parentId = $value;
                $parent = $em->getReference(Collection::class, $value);
                $collectionEntity->setParent($parent);
            }
        });

        $collectionParameters->getPosition()->on(function($value) use (&$position) {
            $position = $value;
        });

        $insert = $position ? "insertAs" : "insertLast";
        $siblings = new SerialManager($this->getCollectionsWithParent($parentId));
        $siblings->$insert($collectionEntity, $position);
    }

    public function getCollectionsWithParent(int $parentId = null)
    {
        if ($parentId) {
            $queryBuilder = $this->createQueryBuilder('c')
                ->andWhere('c.parent = :parent')
                ->setParameter('parent', $parentId);
        } else {
            $queryBuilder = $this->createQueryBuilder('c')
                ->andWhere('c.parent IS NULL');
        }

        /** @var Collection[] $result */
        $result = $queryBuilder->getQuery()->getResult();

        return $result;
    }

    public function getCollectionEntity(int $id): Collection
    {
        $collectionEntity = $this->find($id);
        /** @var Collection $collectionEntity */

        if ($collectionEntity === null) {
            throw new EntityNotFoundException(sprintf("Entity with ID `%d` not found", $id));
        }
        return $collectionEntity;
    }
}