<?php
namespace Domain\Index\Processor\Processors\PublicCatalog;

use Domain\Index\Source\Source;
use Domain\Index\Processor\ProcessorVariants\AbstractExpertProcessor;
use Domain\Profile\Entity\Profile;

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