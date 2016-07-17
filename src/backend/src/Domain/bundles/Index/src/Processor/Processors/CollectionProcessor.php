<?php
namespace Domain\Index\Processor\Processors;

use Domain\Collection\Entity\Collection;
use Domain\Feed\Source\Source;
use Domain\Index\Entity\IndexedEntity;
use Domain\Index\Processor\Processor;

final class CollectionProcessor implements Processor
{
    public function process(IndexedEntity $entity)
    {
        /** @var Collection $entity */
    }
}