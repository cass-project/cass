<?php
namespace Domain\Collection\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Theme\Entity\Theme;

class CollectionRepository extends EntityRepository
{
    public function createCollection(CreateCollectionParameters $parameters): Collection
    {
        $em = $this->getEntityManager();

        $collection = new Collection(
            $parameters->getTitle(),
            $parameters->getDescription(),
            $parameters->hasThemeId() ? $em->getReference(Theme::class, $parameters->getThemeId()) : null
        );

        $em->persist($collection);
        $em->flush($collection);

        return $collection;
    }
}