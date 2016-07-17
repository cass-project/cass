<?php
namespace Domain\Index\Processor\Processors;

use Domain\Feed\Source\Source;
use Domain\Index\Entity\IndexedEntity;
use Domain\Index\Processor\Processor;
use Domain\Profile\Entity\Profile;
use MongoDB\Collection;

final class ProfileProcessor implements Processor
{
    public function process(IndexedEntity $entity)
    {
        /** @var Profile $entity */
    }
}