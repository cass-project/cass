<?php
namespace CASS\Domain\Index\Processor\Processors;

use CASS\Domain\Index\Processor\ProcessorVariants\AbstractPostProcessor;
use CASS\Domain\Index\Source\Source;
use CASS\Domain\Post\Entity\Post;

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