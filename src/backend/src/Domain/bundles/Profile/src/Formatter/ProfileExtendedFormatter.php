<?php
namespace Domain\Profile\Formatter;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Collection\CollectionItem;
use Domain\Collection\Collection\CollectionTree;
use Domain\Collection\Service\CollectionService;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\Profile\Greetings;
use Domain\ProfileCommunities\Entity\ProfileCommunityEQ;
use Domain\ProfileCommunities\Service\ProfileCommunitiesService;

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