<?php
namespace Domain\Index\Processor\Processors\PublicCatalog;

use Domain\Index\Source\Source;
use Domain\Index\Processor\ProcessorVariants\AbstractProfileProcessor;
use Domain\Profile\Entity\Profile;

final class PublicProfilesProcessor extends AbstractProfileProcessor
{
    protected function getSource(Profile $entity): Source
    {
        return $this->sourceFactory->getPublicProfilesSource();
    }

    protected function isIndexable(Profile $entity): bool
    {
        return true;
    }
}