<?php
namespace CASS\Domain\Bundles\Index\Processor\Processors\PublicCatalog;

use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Index\Processor\ProcessorVariants\AbstractCollectionProcessor;
use CASS\Domain\Bundles\Index\Source\Source;

final class PublicCollectionsProcessor extends AbstractCollectionProcessor
{
    protected function getSource(Collection $entity): Source
    {
        return $this->sourceFactory->getPublicCollectionsSource();
    }

    protected function isIndexable(Collection $entity): bool
    {
        $hasTheme = count($entity->getThemeIds()) > 0;
        $notProfileCollection = ! $entity->isMain();

        return $hasTheme && $notProfileCollection;
    }
}