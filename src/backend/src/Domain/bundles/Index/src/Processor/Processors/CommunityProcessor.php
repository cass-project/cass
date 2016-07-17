<?php
namespace Domain\Index\Processor\Processors;

use Domain\Index\Processor\ProcessorVariants\AbstractPostProcessor;
use Domain\Index\Source\Source;
use Domain\Post\Entity\Post;

final class CommunityProcessor extends AbstractPostProcessor
{
    protected function getSource(Post $entity): Source
    {
        return $source = $this->sourceFactory->getCommunitySource($entity->getCollection()->getOwnerId());
    }

    protected function isIndexable(Post $entity): bool
    {
        return $entity->getCollection()->isCommunityCollection();
    }
}