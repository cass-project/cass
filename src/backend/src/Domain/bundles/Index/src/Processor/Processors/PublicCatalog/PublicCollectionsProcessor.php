<?php
namespace Domain\Index\Processor\Processors\PublicCatalog;

use Domain\Collection\Entity\Collection;
use Domain\Index\Processor\ProcessorVariants\AbstractCollectionProcessor;
use Domain\Index\Source\Source;

final class PublicCollectionsProcessor extends AbstractCollectionProcessor
{
    protected function getSource(Collection $entity): Source
    {
        return $this->sourceFactory->getPublicCollectionsSource();
    }

    protected function isIndexable(Collection $entity): bool
    {
        return true;
    }
}