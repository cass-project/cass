<?php
namespace Domain\Index\Processor\Processors\PublicCatalog;

use Domain\Feed\Source\Source;
use Domain\Index\Entity\IndexedEntity;
use Domain\Index\Processor\Processor;
use Domain\Post\Entity\Post;
use MongoDB\Collection;

final class PublicDiscussionsProcessor implements Processor
{
    public function process(IndexedEntity $entity)
    {
        /** @var Post $entity */
    }
}