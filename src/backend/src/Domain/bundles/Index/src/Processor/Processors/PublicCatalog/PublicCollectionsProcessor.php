<?php
namespace CASS\Domain\Index\Processor\Processors\PublicCatalog;

use CASS\Domain\Collection\Entity\Collection;
use CASS\Domain\Index\Processor\ProcessorVariants\AbstractCollectionProcessor;
use CASS\Domain\Index\Source\Source;

final class PublicCollectionsProcessor extends AbstractCollectionProcessor
{
    protected function getSource(Collection $entity): Source
    {
        return $this->sourceFactory->getPublicCollectionsSource();
    }

    protected function isIndexable(Collection $entity): bool
    {
        return count($entity->getThemeIds()) > 0;
    }
}