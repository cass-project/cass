<?php
namespace CASS\Domain\Bundles\Collection\Events;

use CASS\Application\Events\EventsBootstrapInterface;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Collection\Entity\CollectionThemeEQEntity;
use CASS\Domain\Bundles\Collection\Repository\CollectionRepository;
use CASS\Domain\Bundles\Collection\Repository\CollectionThemeEQRepository;
use CASS\Domain\Bundles\Collection\Service\CollectionService;
use CASS\Domain\Bundles\Theme\Entity\Theme;
use CASS\Domain\Bundles\Theme\Service\ThemeService;
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