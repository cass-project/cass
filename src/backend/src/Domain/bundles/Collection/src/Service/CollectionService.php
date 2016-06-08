<?php
namespace Domain\Collection\Service;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Collection\Parameters\EditCollectionParameters;
use Domain\Collection\Repository\CollectionRepository;
use Domain\Collection\Scripts\CollectionImageUploadScript;
use Domain\Community\Parameters\UploadImageParameters;
use Domain\Community\Repository\CommunityRepository;
use Domain\Profile\Repository\ProfileRepository;

class CollectionService
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var CollectionValidatorsService */
    private $validationService;

    /** @var CollectionRepository */
    private $collectionRepository;

    /** @var CommunityRepository */
    private $communityRepository;

    /** @var ProfileRepository */
    private $profileRepository;

    private $storageDir = '';

    public function __construct(
        CollectionValidatorsService $collectionValidatorsService,
        CurrentAccountService $currentAccountService,
        CollectionRepository $collectionRepository,
        CommunityRepository $communityRepository,
        ProfileRepository $profileRepository
    ) {
        $this->validationService = $collectionValidatorsService;
        $this->currentAccountService = $currentAccountService;
        $this->collectionRepository = $collectionRepository;
        $this->communityRepository = $communityRepository;
        $this->profileRepository = $profileRepository;
    }

    public function createCommunityCollection(int $communityId, CreateCollectionParameters $parameters): Collection
    {
        $collection = $this->collectionRepository->createCollection(sprintf('community:%d', $communityId), $parameters);

        $this->communityRepository->linkCollection($communityId, $collection->getId());

        return $collection;
    }

    public function createProfileCollection(CreateCollectionParameters $parameters): Collection
    {
        $profileId = $this->currentAccountService->getCurrentProfile()->getId();

        $collection = $this->collectionRepository->createCollection(sprintf('profile:%d', $profileId), $parameters);
        $this->profileRepository->linkCollection($profileId, $collection->getId());

        return $collection;
    }

    public function deleteCollection(int $collectionId)
    {
        $collection = $this->collectionRepository->getCollectionById($collectionId);
        list($owner, $ownerId) = explode(':', $collection->getOwnerSID());

        if($owner === 'profile') {
            $profile = $this->profileRepository->getProfileById($ownerId);

            $this->validationService->validateIsCollectionOwnedByProfile($collection, $profile);
            $this->profileRepository->unlinkCollection($profile->getId(), $collectionId);
        }else if($owner === 'community') {
            $community = $this->communityRepository->getCommunityById($ownerId);

            $this->validationService->validateIsCollectionOwnedByCommunity($collection, $community);
            $this->communityRepository->unlinkCollection($community->getId(), $collectionId);
        }else{
            throw new \Exception('Unknown owner');
        }

        $this->collectionRepository->deleteCollection($collectionId);
    }

    public function editCollection(int $collectionId, EditCollectionParameters $parameters): Collection
    {
        $collection = $this->collectionRepository->getCollectionById($collectionId);
        list($owner, $ownerId) = explode(':', $collection->getOwnerSID());

        if($owner === 'profile') {
            $profile = $this->profileRepository->getProfileById($ownerId);

            $this->validationService->validateIsCollectionOwnedByProfile($collection, $profile);
        }else if($owner === 'community') {
            $community = $this->communityRepository->getCommunityById($ownerId);

            $this->validationService->validateIsCollectionOwnedByCommunity($collection, $community);
        }else{
            throw new \Exception('Unknown owner');
        }

        return $this->collectionRepository->editCollection($collectionId, $parameters);
    }

    public function uploadCollectoinImage(int $collectionId, UploadImageParameters $parameters): Collection
    {
        $collection = $this->collectionRepository->getCollectionById($collectionId);
        $uploadScript = new CollectionImageUploadScript($this->storageDir);

        $params = $uploadScript->__invoke($collectionId,$parameters->getTmpFile(),$parameters->getPointStart(),$parameters->getPointEnd());

        $collection->setImage(
          new Collection\CollectionImage(
                                $params['path'],
                                sprintf('%s/%d/%s', $this->publicPath, $params['id'], $params['file'])
                              )
        );

        $this->collectionRepository->saveCollection($collection);
    }
}