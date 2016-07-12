<?php
namespace Domain\Feed\Source\PublicCatalog;

use Domain\Collection\Entity\Collection;
use Domain\Feed\Service\Entity;
use Domain\Feed\Source\Source;

final class PublicCollectionsSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_collections';
    }

    public function test(Entity $entity)
    {
        return $entity instanceof Collection;
    }
}