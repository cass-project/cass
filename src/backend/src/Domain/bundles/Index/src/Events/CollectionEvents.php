<?php
namespace CASS\Domain\Index\Events;

use CASS\Application\Events\EventsBootstrapInterface;
use CASS\Domain\Collection\Entity\Collection;
use CASS\Domain\Collection\Service\CollectionService;
use CASS\Domain\Index\Service\IndexService;
use Evenement\EventEmitterInterface;

final class CollectionEvents implements EventsBootstrapInterface
{
    /** @var IndexService */
    private $indexService;

    /** @var CollectionService */
    private $collectionService;

    public function __construct(IndexService $indexService, CollectionService $collectionService)
    {
        $this->indexService = $indexService;
        $this->collectionService = $collectionService;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $is = $this->indexService;
        $cs = $this->collectionService;

        $cs->getEventEmitter()->on(CollectionService::EVENT_COLLECTION_CREATED, function(Collection $collection) use ($is, $cs) {
            $is->indexEntity($collection);
        });

        $cs->getEventEmitter()->on(CollectionService::EVENT_COLLECTION_EDITED, function(Collection $collection) use ($is, $cs) {
            $is->indexEntity($collection);
        });

        $cs->getEventEmitter()->on(CollectionService::EVENT_COLLECTION_DELETE, function(Collection $collection) use ($is, $cs) {
            $is->excludeEntity($collection);
        });
    }
}