<?php
namespace Domain\Collection\Service;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Collection\Parameters\EditCollectionParameters;
use Domain\Collection\Parameters\SetPublicOptionsParameters;
use Domain\Collection\Repository\CollectionRepository;
use Domain\Community\Repository\CommunityRepository;
use Domain\Avatar\Image\Image;
use Domain\Avatar\Image\ImageCollection;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Repository\ProfileRepository;
use League\Flysystem\FilesystemInterface;

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

    /** @var FilesystemInterface */
    private $images;

    /** @var string */
    private $assetsPath;

    /** @var string */
    private $assetsDir;

    public function __construct(
        CollectionValidatorsService $collectionValidatorsService,
        CurrentAccountService $currentAccountService,
        CollectionRepository $collectionRepository,
        CommunityRepository $communityRepository,
        ProfileRepository $profileRepository,
        FilesystemInterface $imagesFlySystem,
        string $assetsPath,
        string $assetsDir
    ) {
        $this->validationService = $collectionValidatorsService;
        $this->currentAccountService = $currentAccountService;
        $this->collectionRepository = $collectionRepository;
        $this->communityRepository = $communityRepository;
        $this->profileRepository = $profileRepository;
        $this->images = $profileRepository;
        $this->assetsPath = $assetsPath;
        $this->assetsDir = $assetsDir;
    }

    public function createCommunityCollection(int $communityId, CreateCollectionParameters $parameters): Collection
    {
        $collection = $this->collectionRepository->createCollection(
            sprintf('community:%d', $communityId),
            $this->getDefaultImages(),
            $parameters
        );

        $this->communityRepository->linkCollection($communityId, $collection->getId());

        return $collection;
    }

    public function createProfileCollection(Profile $profile, CreateCollectionParameters $parameters): Collection
    {
        $profileId = $profile->getId();

        $collection = $this->collectionRepository->createCollection(
            sprintf('profile:%d', $profileId),
            $this->getDefaultImages(),
            $parameters
        );

        $this->profileRepository->linkCollection($profile, $collection->getId());

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

    public function setPublicOptions(int $collectionId, SetPublicOptionsParameters $parameters): Collection
    {
        return $this->collectionRepository->updatePublicOptions($collectionId, $parameters);
    }

    private function getDefaultImages()
    {
        return (new ImageCollection())
            ->attachImage('small', new Image(
                sprintf('%s/community-default.png', $this->assetsDir),
                sprintf('%s/community-default.png', $this->assetsPath)
            ))
            ->attachImage('small', new Image(
                sprintf('%s/community-default.png', $this->assetsDir),
                sprintf('%s/community-default.png', $this->assetsPath)
            ))
        ;
    }

    public function createDefaultCollectionForProfile(Profile $profile)
    {
        $collectionParameters = new CreateCollectionParameters(
            $profile->getId(),
            '$gt_collection_my-feed_title',
            '$gt_collection_my-feed_description'
        );

        $this->createProfileCollection($profile, $collectionParameters);
    }
    
    public function getCollectionById(int $collectionId): Collection
    {
        return $this->collectionRepository->getCollectionById($collectionId);
    }
    
    public function getCollectionsById(array $collectionIds): array
    {
        return $this->collectionRepository->getCollectionsById($collectionIds);
    }
}