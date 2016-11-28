<?php
namespace CASS\Domain\Bundles\Profile\Formatter;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Collection\Collection\CollectionItem;
use CASS\Domain\Bundles\Collection\Collection\CollectionTree;
use CASS\Domain\Bundles\Collection\Service\CollectionService;
use CASS\Domain\Bundles\Profile\Entity\Card\Access\ProfileCardAccess;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Service\ProfileCardService;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Service\SubscribeService;

final class ProfileExtendedFormatter
{
    /** @var CollectionService */
    private $collectionService;

    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var SubscribeService */
    private $subscribeService;

    /** @var ProfileCardService */
    private $profileCardService;

    public function __construct(
        CollectionService $collectionService,
        CurrentAccountService $currentAccountService,
        SubscribeService $subscribeService,
        ProfileCardService $profileCardService
    )
    {
        $this->collectionService = $collectionService;
        $this->currentAccountService = $currentAccountService;
        $this->subscribeService = $subscribeService;
        $this->profileCardService = $profileCardService;
    }

    public function format(Profile $profile): array
    {
        $isOwn = $this->currentAccountService->isAvailable()
            ? $this->currentAccountService->getCurrentAccount()->getProfiles()->contains($profile)
            : false;

        $accessLevel = $this->currentAccountService->isAvailable()
            ? $this->profileCardService->resoluteAccessLevel($profile, $this->currentAccountService->getCurrentAccount()->getCurrentProfile())
            : [ProfileCardAccess::ACCESS_PUBLIC];

        $isSubscribedTo = $this->currentAccountService->isAvailable()
            ? $this->subscribeService->hasSubscribe(
                $this->currentAccountService->getCurrentAccount()->getCurrentProfile()->getId(),
                Subscribe::TYPE_PROFILE,
                $profile->getId()
            )
            : false;

        return [
            'profile' => $profile->toJSON(),
            'card' => $this->profileCardService->exportProfileCard($profile, $accessLevel)->toJSON(),
            'collections' => $this->formatCollections($profile->getCollections()),
            'is_own' => $isOwn,
            'subscribed' => $isSubscribedTo,
        ];
    }

    private function formatCollections(CollectionTree $tree): array
    {
        return array_map(function(CollectionItem $item) {
            $json = $this->collectionService->getCollectionById($item->getCollectionId())->toJSON();

            if($item->hasChildren()) {
                $json['children'] = $this->formatCollections($item->sub());
            }else{
                $json['children'] = [];
            }

            $json['subscribed'] = false;

            return $json;
        }, $tree->getItems());
    }
}