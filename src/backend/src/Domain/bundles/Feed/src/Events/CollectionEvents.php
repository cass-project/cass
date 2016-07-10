<?php
namespace Domain\Feed\Events;

use Application\Events\EventsBootstrapInterface;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Service\CollectionService;
use Domain\Feed\Factory\FeedSourceFactory;
use Domain\Feed\Service\EntityRouterService;
use Evenement\EventEmitterInterface;

final class CollectionEvents implements EventsBootstrapInterface
{
    /** @var CollectionService */
    private $collectionService;

    /** @var EntityRouterService */
    private $entityRouterService;

    /** @var FeedSourceFactory */
    private $sourceFactory;

    public function __construct(
        CollectionService $collectionService,
        EntityRouterService $entityRouterService,
        FeedSourceFactory $sourceFactory
    ) {
        $this->collectionService = $collectionService;
        $this->entityRouterService = $entityRouterService;
        $this->sourceFactory = $sourceFactory;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $cs = $this->collectionService;
        $er = $this->entityRouterService;
        $sc = $this->sourceFactory;

        $cs->getEventEmitter()->on(CollectionService::EVENT_COLLECTION_CREATED, function(Collection $collection) use ($cs, $er, $sc) {
            $er->upsert($collection, [
                $sc->getPublicCollectionsSource()
            ]);
        });

        $cs->getEventEmitter()->on(CollectionService::EVENT_COLLECTION_EDITED, function(Collection $collection) use ($cs, $er, $sc) {
            $er->upsert($collection, [
                $sc->getPublicCollectionsSource()
            ]);
        });

        $cs->getEventEmitter()->on(CollectionService::EVENT_COLLECTION_DELETE, function(Collection $collection) use ($cs, $er, $sc) {
            $er->delete($collection, [
                $sc->getPublicCollectionsSource()
            ]);
        });
    }
}