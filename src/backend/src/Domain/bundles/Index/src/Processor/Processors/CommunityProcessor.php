<?php
namespace CASS\Domain\Bundles\Index\Processor\Processors;

use CASS\Domain\Bundles\Index\Processor\ProcessorVariants\AbstractPostProcessor;
use CASS\Domain\Bundles\Index\Source\Source;
use CASS\Domain\Bundles\Post\Entity\Post;

final class CommunityProcessor extends AbstractPostProcessor
{
    protected function getSources(Post $entity): array
    {
        return [
            $this->sourceFactory->getCommunitySource($entity->getCollection()->getOwnerId()),
        ];
    }

    protected function isIndexable(Post $entity): bool
    {
        return $entity->getCollection()->isCommunityCollection();
    }
}