<?php
namespace CASS\Domain\Bundles\Index\Processor\Processors\PersonalPeopleProcessor;

use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Index\Processor\ProcessorVariants\AbstractCollectionProcessor;
use CASS\Domain\Bundles\Index\Source\Source;

final class PersonalPeopleProcessor extends AbstractCollectionProcessor
{
    protected function getSource(Collection $entity): Source
    {
        // TODO: Implement getSource() method.
    }

    protected function isIndexable(Collection $entity): bool
    {
        // TODO: Implement isIndexable() method.
    }
}