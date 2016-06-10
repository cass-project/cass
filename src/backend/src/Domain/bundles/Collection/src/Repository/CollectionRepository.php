<?php
namespace Domain\Collection\Repository;

use Application\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Collection\Parameters\EditCollectionParameters;
use Domain\Definitions\ImageCollection\ImageCollection;
use Domain\Profile\Entity\Profile;
use Domain\Theme\Entity\Theme;

class CollectionRepository extends EntityRepository
{
    public function createCollection(string $ownerSID, ImageCollection $images, CreateCollectionParameters $parameters): Collection
    {
        $em = $this->getEntityManager();

        $collection = new Collection(
            $em->getReference(Profile::class, $parameters->getAuthorProfileId()),
            $ownerSID,
            $parameters->getTitle(),
            $parameters->getDescription(),
            $parameters->hasThemeId() ? $em->getReference(Theme::class, $parameters->getThemeId()) : null
        );


        $collection->exportImages($images);

        $em->persist($collection);
        $em->flush($collection);

        return $collection;
    }

    public function getCollectionById(int $collectionId): Collection
    {
        $result = $this->find($collectionId);

        if($result === null) {
            throw new EntityNotFoundException(sprintf('Collection with ID `%d` not found', $collectionId));
        }

        return $result;
    }

    public function deleteCollection(int $collectionId)
    {
        $collection = $this->getCollectionById($collectionId);

        $this->getEntityManager()->remove($collection);
        $this->getEntityManager()->flush($collection);
    }

    public function editCollection(int $collectionId, EditCollectionParameters $parameters): Collection
    {
        $em = $this->getEntityManager();

        $collection = $this->getCollectionById($collectionId);
        $collection->setTitle($parameters->getTitle());
        $collection->setDescription($parameters->getDescription());

        if($parameters->hasThemeId()) {
            $collection->setTheme($em->getReference(Theme::class, $parameters->getThemeId()));
        }else{
            $collection->unsetTheme();
        }

        $em->flush($collection);

        return $collection;
    }
}