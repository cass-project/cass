<?php
namespace Domain\Index\Processor;

use Domain\Index\Entity\IndexedEntity;

interface Processor
{
    public function process(IndexedEntity $entity);
    public function exclude(IndexedEntity $entity);
}