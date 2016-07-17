<?php
namespace Domain\Index\Service;

use Domain\Index\Entity\IndexedEntity;
use Domain\Index\Processor\Processor;
use Domain\Index\Processor\ProcessorFactory;

final class IndexService
{
    /** @var ProcessorFactory */
    private $processorsFactory;

    public function indexEntity(IndexedEntity $entity)
    {
        array_map(function(Processor $processor) use ($entity) {
            $processor->process($entity);
        }, $this->processorsFactory->createProcessorsFor($entity));
    }

    public function excludeEntity(IndexedEntity $entity)
    {
        array_map(function(Processor $processor) use ($entity) {
            $processor->exclude($entity);
        }, $this->processorsFactory->createProcessorsFor($entity));
    }
}