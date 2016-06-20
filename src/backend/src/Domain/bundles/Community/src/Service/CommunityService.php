<?php
namespace Domain\Community\Service;

use Domain\Account\Entity\Account;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Avatar\Image\ImageCollection;
use Domain\Avatar\Parameters\UploadImageParameters;
use Domain\Avatar\Service\AvatarService;
use Domain\Collection\Collection\CollectionTree\ImmutableCollectionTree;
use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Collection\Service\CollectionService;
use Domain\Community\ACL\CommunityACL;
use Domain\Community\Entity\Community;
use Domain\Community\Image\CommunityImageStrategy;
use Domain\Community\Parameters\CreateCommunityParameters;
use Domain\Community\Parameters\EditCommunityParameters;
use Domain\Community\Parameters\SetPublicOptionsParameters;
use Domain\Community\Repository\CommunityRepository;
use Domain\Theme\Repository\ThemeRepository;
use League\Flysystem\FilesystemInterface;

class CommunityService
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var CommunityRepository */
    private $communityRepository;
    
    /** @var ThemeRepository */
    private $themeRepository;

    /** @var CollectionService */
    private $collectionService;

    /** @var AvatarService */
    private $avatarService;

    /** @var FilesystemInterface */
    private $imageFileSystem;

    public function __construct(
        CurrentAccountService $currentAccountService,
        CommunityRepository $communityRepository,
        CollectionService $collectionService,
        ThemeRepository $themeRepository,
        AvatarService $avatarService,
        FilesystemInterface $imageFileSystem
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->communityRepository = $communityRepository;
        $this->collectionService = $collectionService;
        $this->themeRepository = $themeRepository;
        $this->avatarService = $avatarService;
        $this->imageFileSystem = $imageFileSystem;
    }
    
    public function createCommunity(CreateCommunityParameters $parameters): Community {
        $owner = $this->currentAccountService->getCurrentAccount();
        $entity = new Community(
            $owner->getId(),
            $parameters->getTitle(),
            $parameters->getDescription(),
            $parameters->hasThemeId()
                ? $this->themeRepository->getThemeById($parameters->getThemeId())
                : null
        );

        $this->communityRepository->createCommunity($entity);

        $strategy = new CommunityImageStrategy($entity, $this->imageFileSystem);
        $this->collectionService->createCollection(new CreateCollectionParameters(
            sprintf('community:%s', $entity->getId()),
            '$gt_community-feed_title',
            '$gt_community-feed_description',
            $entity->hasTheme()
                ? [$entity->getTheme()->getId()]
                : []
        ));
        $this->avatarService->generateImage($strategy);

        return $entity;
    }

    public function editCommunity(int $communityId, EditCommunityParameters $parameters): Community {
        $community = $this->communityRepository->getCommunityById($communityId);
        $community->setTitle($parameters->getTitle());
        $community->setDescription($parameters->getDescription());

        if($parameters->hasThemeId()) {
            $community->setTheme($this->themeRepository->getThemeById($parameters->getThemeId()));
        }else{
            $community->unsetTheme();
        }

        $this->communityRepository->saveCommunity($community);

        return $community;
    }

    public function uploadCommunityImage(int $communityId, UploadImageParameters $parameters): ImageCollection {
        $community = $this->communityRepository->getCommunityById($communityId);
        $strategy = new CommunityImageStrategy($community, $this->imageFileSystem);

        $this->avatarService->uploadImage($strategy, $parameters);
        $this->communityRepository->saveCommunity($community);

        return $community->getImages();
    }

    public function generateCommunityImage(int $communityId): ImageCollection
    {
        $community = $this->communityRepository->getCommunityById($communityId);
        $strategy = new CommunityImageStrategy($community, $this->imageFileSystem);

        $this->avatarService->defaultImage($strategy);
        $this->communityRepository->saveCommunity($community);

        return $community->getImages();
    }

    public function setPublicOptions(int $communityId, SetPublicOptionsParameters $parameters): Community {
        $community = $this->communityRepository->getCommunityById($communityId);

        $parameters->isPublicEnabled()
            ? $community->enablePublicDiscover()
            : $community->disablePublicDiscover();

        $parameters->isModerationContract()
            ? $community->enableModerationContract()
            : $community->disableModerationContract();

        $this->communityRepository->saveCommunity($community);

        return $community;
    }

    public function linkCollection(int $communityId, int $collectionId): ImmutableCollectionTree
    {
        $community = $this->getCommunityById($communityId);

        $collections = $community->getCollections()->createMutableInstance();

        if(! $collections->hasCollection($collectionId)) {
            $collections->attachChild($collectionId);
        }

        $community->replaceCollections($collections->createImmutableInstance());
        $this->communityRepository->saveCommunity($community);

        return $community->getCollections();
    }

    public function unlinkCollection(int $communityId, int $collectionId): ImmutableCollectionTree
    {
        $community = $this->getCommunityById($communityId);

        $collections = $community->getCollections()->createMutableInstance();

        if($collections->hasCollection($collectionId)) {
            $collections->detachChild($collectionId);
        }

        $community->replaceCollections($collections->createImmutableInstance());
        $this->communityRepository->saveCommunity($community);

        return $community->getCollections();
    }

    public function getCommunityById(string $communityId): Community {
        return $this->communityRepository->getCommunityById($communityId);
    }

    public function getCommunityBySID(string $communitySID): Community {
        return $this->communityRepository->getCommunityBySID($communitySID);
    }

    public function getCommunityAccess(Account $account, Community $community): CommunityACL
    {
        $hasAdminAccess = $community->getMetadata()['creatorAccountId'] === $account->getId();

        return new CommunityACL($hasAdminAccess);
    }
}