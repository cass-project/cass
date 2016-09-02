<?php
namespace CASS\Domain\Bundles\Index\Processor\Processors\PublicCatalog;

use CASS\Domain\Bundles\Index\Source\Source;
use CASS\Domain\Bundles\Index\Processor\ProcessorVariants\AbstractExpertProcessor;
use CASS\Domain\Bundles\Profile\Entity\Profile;

final class PublicExpertsProcessor extends AbstractExpertProcessor
{
    protected function getSource(Profile $entity): Source
    {
        return $this->sourceFactory->getPublicExpertsSource();
    }

    protected function isIndexable(Profile $entity): bool
    {
        return true;
    }

}