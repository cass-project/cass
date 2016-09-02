<?php
namespace CASS\Domain\Index\Processor\Processors;

use CASS\Domain\Index\Processor\ProcessorVariants\AbstractPostProcessor;
use CASS\Domain\Index\Source\Source;
use CASS\Domain\Post\Entity\Post;

final class ProfileProcessor extends AbstractPostProcessor
{
    protected function getSource(Post $entity): Source
    {
        return $source = $this->sourceFactory->getProfileSource($entity->getCollection()->getOwnerId());
    }

    protected function isIndexable(Post $entity): bool
    {
        return $entity->getCollection()->isProfileCollection();
    }
}