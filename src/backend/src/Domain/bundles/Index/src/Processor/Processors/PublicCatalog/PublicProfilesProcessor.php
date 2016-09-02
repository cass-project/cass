<?php
namespace CASS\Domain\Index\Processor\Processors\PublicCatalog;

use CASS\Domain\Index\Source\Source;
use CASS\Domain\Index\Processor\ProcessorVariants\AbstractProfileProcessor;
use CASS\Domain\Profile\Entity\Profile;

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