<?php
namespace CASS\Domain\Index\Processor;

use CASS\Domain\Index\Entity\IndexedEntity;

interface Processor
{
    public function process(IndexedEntity $entity);
    public function exclude(IndexedEntity $entity);
}