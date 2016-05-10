<?php
namespace Domain\Collection\Service;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Collection\Repository\CollectionRepository;
use Domain\Community\Repository\CommunityRepository;
use Domain\Community\Service\CommunityService;
use Domain\Profile\Repository\ProfileRepository;
use Domain\Profile\Service\ProfileService;
use Domain\Theme\Repository\ThemeRepository;

class CollectionService
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var CollectionRepository */
    private $collectionRepository;

    /** @var CommunityRepository */
    private $communityRepository;

    /** @var ProfileRepository */
    private $profileRepository;

    public function __construct(
        CurrentAccountService $currentAccountService,
        CollectionRepository $collectionRepository,
        CommunityRepository $communityRepository,
        ProfileRepository $profileRepository
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->collectionRepository = $collectionRepository;
        $this->communityRepository = $communityRepository;
        $this->profileRepository = $profileRepository;
    }

    public function createCommunityCollection(int $communityId, CreateCollectionParameters $parameters): Collection
    {
        $collection = $this->collectionRepository->createCollection($parameters);

        $this->communityRepository->linkCollection($communityId, $collection->getId());

        return $collection;
    }

    public function createProfileCollection(CreateCollectionParameters $parameters): Collection
    {
        $profileId = $this->currentAccountService->getCurrentProfile()->getId();

        $collection = $this->collectionRepository->createCollection($parameters);
        $this->profileRepository->linkCollection($profileId, $collection->getId());

        return $collection;
    }
}