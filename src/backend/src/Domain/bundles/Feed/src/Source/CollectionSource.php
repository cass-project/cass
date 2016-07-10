<?php
namespace Domain\Feed\Source;

use Domain\Collection\Entity\Collection;
use Domain\Feed\Service\Entity;
use Domain\Post\Entity\Post;

final class CollectionSource implements Source
{
    /** @var int */
    private $collectionId;

    public function __construct(int $collectionId)
    {
        $this->collectionId = $collectionId;
    }

    public function getMongoDBCollection(): string
    {
        return sprintf('collection_feed_%d', $this->collectionId);
    }

    public function test(Entity $entity)
    {
        /** @var Post $entity */
        
        return
            ($testIsPostEntity = $entity instanceof Post)
         && ($testIsInCollection = $entity->getCollection()->getId() === $this->collectionId);
    }
}