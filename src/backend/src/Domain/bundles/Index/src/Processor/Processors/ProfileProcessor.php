<?php
namespace CASS\Domain\Bundles\Index\Processor\Processors;

use CASS\Domain\Bundles\Index\Processor\ProcessorVariants\AbstractPostProcessor;
use CASS\Domain\Bundles\Index\Source\Source;
use CASS\Domain\Bundles\Post\Entity\Post;

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