<?php
namespace Domain\Index\Processor\Processors\PublicCatalog;

use Domain\Community\Entity\Community;
use Domain\Index\Processor\ProcessorVariants\AbstractCommunityProcessor;
use Domain\Index\Source\Source;

final class PublicCommunitiesProcessor extends AbstractCommunityProcessor
{
    protected function getSource(Community $entity): Source
    {
        return $this->sourceFactory->getPublicCommunitiesSource();
    }

    protected function isIndexable(Community $entity): bool
    {
        return true;
    }
}