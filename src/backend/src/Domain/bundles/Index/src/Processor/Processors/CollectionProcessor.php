<?php
namespace Domain\Index\Processor\Processors;

use Domain\Index\Processor\ProcessorVariants\AbstractPostProcessor;
use Domain\Index\Source\Source;
use Domain\Post\Entity\Post;

final class CollectionProcessor extends AbstractPostProcessor
{
    protected function getSource(Post $entity): Source
    {
        return $source = $this->sourceFactory->getCollectionSource($entity->getCollection()->getId());
    }

    protected function isIndexable(Post $entity): bool
    {
        return true;
    }
}