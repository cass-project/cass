<?php
namespace CASS\Domain\Bundles\Index\Processor\Processors\PublicCatalog;

use CASS\Domain\Bundles\Index\Source\Source;
use CASS\Domain\Bundles\Index\Processor\ProcessorVariants\AbstractProfileProcessor;
use CASS\Domain\Bundles\Profile\Entity\Profile;

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