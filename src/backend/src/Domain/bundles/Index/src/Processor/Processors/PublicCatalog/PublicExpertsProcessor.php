<?php
namespace CASS\Domain\Index\Processor\Processors\PublicCatalog;

use CASS\Domain\Index\Source\Source;
use CASS\Domain\Index\Processor\ProcessorVariants\AbstractExpertProcessor;
use CASS\Domain\Profile\Entity\Profile;

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