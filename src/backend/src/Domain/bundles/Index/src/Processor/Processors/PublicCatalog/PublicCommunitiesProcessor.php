<?php
namespace CASS\Domain\Bundles\Index\Processor\Processors\PublicCatalog;

use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Index\Processor\ProcessorVariants\AbstractCommunityProcessor;
use CASS\Domain\Bundles\Index\Source\Source;

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