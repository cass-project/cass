<?php
namespace Domain\Index\Processor\Processors\PublicCatalog;

use Domain\Feed\Source\Source;
use Domain\Index\Entity\IndexedEntity;
use Domain\Index\Processor\Processor;
use MongoDB\Collection;

final class PublicCollectionsProcessor implements Processor
{
    public function process(IndexedEntity $entity)
    {
        /** @var \Domain\Collection\Entity\Collection $entity */
    }
}