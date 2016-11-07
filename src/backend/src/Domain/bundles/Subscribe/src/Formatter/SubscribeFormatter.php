<?php
namespace CASS\Domain\Bundles\Subscribe\Formatter;

use CASS\Domain\Bundles\Collection\Service\CollectionService;
use CASS\Domain\Bundles\Community\Service\CommunityService;
use CASS\Domain\Bundles\Profile\Service\ProfileService;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Theme\Service\ThemeService;
use CASS\Util\JSONSerializable;

final class SubscribeFormatter
{
    /** @var ProfileService */
    private $profileService;

    /** @var ThemeService */
    private $themeService;

    /** @var CollectionService */
    private $collectionService;

    /** @var CommunityService */
    private $communityService;

    public function __construct(
        ProfileService $profileService,
        ThemeService $themeService,
        CollectionService $collectionService,
        CommunityService $communityService
    ) {
        $this->profileService = $profileService;
        $this->themeService = $themeService;
        $this->collectionService = $collectionService;
        $this->communityService = $communityService;
    }

    public function formatMany(array $entities)
    {
        return array_map(function(Subscribe $subscribe) {
            return $this->formatSingle($subscribe);
        }, $entities);
    }

    public function formatSingle(Subscribe $subscribe)
    {
        return array_merge($subscribe->toJSON(), [
            'entity' => $this->getEntityJSON($subscribe)->toJSON(),
        ]);
    }

    private function getEntityJSON(Subscribe $subscribe): JSONSerializable
    {
        $entityId = $subscribe->getSubscribeId();

        switch($subscribe->getSubscribeType()) {
            default:
                throw new \Exception(sprintf('Unknown subscribe type `%d`', $subscribe->getSubscribeType()));

            case Subscribe::TYPE_THEME:
                return $this->themeService->getThemeById($entityId);

            case Subscribe::TYPE_PROFILE:
                return $this->profileService->getProfileById($entityId);

            case Subscribe::TYPE_COLLECTION:
                return $this->collectionService->getCollectionById($entityId);

            case Subscribe::TYPE_COMMUNITY:
                return $this->communityService->getCommunityById($entityId);
        }
    }
}