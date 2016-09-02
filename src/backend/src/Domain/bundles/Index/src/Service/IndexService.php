<?php
namespace CASS\Domain\Bundles\Index\Service;

use CASS\Domain\Bundles\Index\Entity\IndexedEntity;
use CASS\Domain\Bundles\Index\Processor\Processor;
use CASS\Domain\Bundles\Index\Processor\ProcessorFactory;

final class IndexService
{
    /** @var ProcessorFactory */
    private $processorsFactory;

    public function __construct(ProcessorFactory $processorsFactory)
    {
        $this->processorsFactory = $processorsFactory;
    }

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