<?php
namespace Domain\Index\Processor\Processors\PublicCatalog;

use Domain\Community\Entity\Community;
use Domain\Feed\Source\Source;
use Domain\Index\Entity\IndexedEntity;
use Domain\Index\Processor\Processor;
use MongoDB\Collection;

final class PublicCommunitiesProcessor implements Processor
{
    public function process(IndexedEntity $entity)
    {
        /** @var Community $entity */
    }
}