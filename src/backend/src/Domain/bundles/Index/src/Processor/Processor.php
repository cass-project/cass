<?php
namespace CASS\Domain\Bundles\Index\Processor;

use CASS\Domain\Bundles\Index\Entity\IndexedEntity;

interface Processor
{
    public function process(IndexedEntity $entity);
    public function exclude(IndexedEntity $entity);
}