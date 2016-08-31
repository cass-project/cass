<?php
namespace Domain\Collection\Events;

use CASS\Application\Events\EventsBootstrapInterface;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Entity\CollectionThemeEQEntity;
use Domain\Collection\Repository\CollectionRepository;
use Domain\Collection\Repository\CollectionThemeEQRepository;
use Domain\Collection\Service\CollectionService;
use Domain\Theme\Entity\Theme;
use Domain\Theme\Service\ThemeService;
use Evenement\EventEmitterInterface;

final class CollectionThemesEQEvents implements EventsBootstrapInterface
{
    /** @var CollectionThemeEQRepository */
    private $eq;

    /** @var ThemeService */
    private $themeService;

    /** @var CollectionService */
    private $collectionService;

    /** @var CollectionRepository */
    private $collectionRepository;

    public function __construct(
        CollectionThemeEQRepository $eq,
        ThemeService $themeService,
        CollectionService $collectionService,
        CollectionRepository $collectionRepository
    ) {
        $this->eq = $eq;
        $this->themeService = $themeService;
        $this->collectionService = $collectionService;
        $this->collectionRepository = $collectionRepository;
    }

    public function up(EventEmitterInterface $globalEmitter)
    {
        $eq = $this->eq;
        $collectionService = $this->collectionService;
        $themeService = $this->themeService;

        $themeService->getEventEmitter()->on(ThemeService::EVENT_DELETE, function(Theme $theme) use ($eq, $collectionService) {
            array_reduce($eq->getCollectionsByThemeId($theme->getId()), function(CollectionThemeEQEntity $eq) use ($collectionService) {
                $collection = $collectionService->getCollectionById($eq->getCollectionId());
                $collection->setThemeIds(array_filter($collection->getThemeIds(), function($input) use ($eq) {
                    return (int) $input !== (int) $eq->getThemeId();
                }));

                if(! count($collection->getThemeIds())) {
                    $collection->setPublicOptions([
                        'is_private' => $collection->isPrivate(),
                        'public_enabled' => false,
                        'moderation_contract' => false
                    ]);
                }

                // TODO:: Notification about turning off public
                $this->collectionRepository->saveCollection($collection);
            });
        });

        $collectionService->getEventEmitter()->on(CollectionService::EVENT_COLLECTION_CREATED, function(Collection $collection) use ($eq) {
            $eq->sync($collection->getId(), $collection->getThemeIds());
        });

        $collectionService->getEventEmitter()->on(CollectionService::EVENT_COLLECTION_EDITED, function(Collection $collection) use ($eq) {
            $eq->sync($collection->getId(), $collection->getThemeIds());
        });

        $collectionService->getEventEmitter()->on(CollectionService::EVENT_COLLECTION_DELETE, function(Collection $collection) use ($eq) {
            $eq->deleteEQOfCollection($collection->getId());
        });
    }
}