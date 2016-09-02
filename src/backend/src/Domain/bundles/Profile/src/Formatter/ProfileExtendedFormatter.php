<?php
namespace CASS\Domain\Bundles\Profile\Formatter;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Collection\Collection\CollectionItem;
use CASS\Domain\Bundles\Collection\Collection\CollectionTree;
use CASS\Domain\Bundles\Collection\Service\CollectionService;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Entity\Profile\Greetings;
use CASS\Domain\Bundles\ProfileCommunities\Entity\ProfileCommunityEQ;
use CASS\Domain\Bundles\ProfileCommunities\Service\ProfileCommunitiesService;

final class ProfileExtendedFormatter
{
    /** @var CollectionService */
    private $collectionService;

    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var ProfileCommunitiesService */
    private $communityBookmarksService;

    public function __construct(
        CollectionService $collectionService,
        CurrentAccountService $currentAccountService,
        ProfileCommunitiesService $communityBookmarksService
    ) {
        $this->collectionService = $collectionService;
        $this->currentAccountService = $currentAccountService;
        $this->communityBookmarksService = $communityBookmarksService;
    }

    public function format(Profile $profile): array {
        return [
            'profile' => $profile->toJSON(),
            'collections' => $this->formatCollections($profile->getCollections()),
            'bookmarks' => array_map(function(ProfileCommunityEQ $eq) {
                return $eq->toJSON();
            }, $this->communityBookmarksService->getBookmarksOfProfile($profile->getId())),
            'is_own' => $this->currentAccountService->isAvailable()
                ? $this->currentAccountService->getCurrentAccount()->getProfiles()->contains($profile)
                : false
        ];
    }

    private function formatCollections(CollectionTree $tree): array {
        return array_map(function(CollectionItem $item) {
            $json = $this->collectionService->getCollectionById($item->getCollectionId())->toJSON();

            if($item->hasChildren()) {
                $json['children'] = $this->formatCollections($item->sub());
            }else{
                $json['children'] = [];
            }

            return $json;
        }, $tree->getItems());
    }
}