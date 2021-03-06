<?php
namespace CASS\Domain\Bundles\Community\Service;

use CASS\Application\Service\EventEmitterAware\EventEmitterAwareService;
use CASS\Application\Service\EventEmitterAware\EventEmitterAwareTrait;
use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Avatar\Image\ImageCollection;
use CASS\Domain\Bundles\Avatar\Parameters\UploadImageParameters;
use CASS\Domain\Bundles\Avatar\Service\AvatarService;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Collection\Collection\CollectionTree\ImmutableCollectionTree;
use CASS\Domain\Bundles\Community\Backdrop\Preset\CommunityBackdropPresetFactory;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Community\Image\CommunityImageStrategy;
use CASS\Domain\Bundles\Community\Parameters\CreateCommunityParameters;
use CASS\Domain\Bundles\Community\Parameters\EditCommunityParameters;
use CASS\Domain\Bundles\Community\Parameters\SetPublicOptionsParameters;
use CASS\Domain\Bundles\Community\Repository\CommunityRepository;
use CASS\Domain\Bundles\Theme\Repository\ThemeRepository;
use League\Flysystem\FilesystemInterface;

class CommunityService implements EventEmitterAwareService
{
    use EventEmitterAwareTrait;

    const EVENT_COMMUNITY_CREATED = 'domain.community.created';
    const EVENT_COMMUNITY_UPDATED = 'domain.community.updated';
    const EVENT_COMMUNITY_DELETE = 'domain.community.delete';
    const EVENT_COMMUNITY_DELETED = 'domain.community.deleted';

    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var CommunityRepository */
    private $communityRepository;

    /** @var ThemeRepository */
    private $themeRepository;

    /** @var AvatarService */
    private $avatarService;

    /** @var BackdropService */
    private $backdropService;

    /** @var CommunityBackdropPresetFactory */
    private $backdropPresetFactory;

    /** @var FilesystemInterface */
    private $imageFileSystem;

    /** @var string */
    private $wwwImageDir;

    public function __construct(
        CurrentAccountService $currentAccountService,
        CommunityRepository $communityRepository,
        ThemeRepository $themeRepository,
        AvatarService $avatarService,
        BackdropService $backdropService,
        CommunityBackdropPresetFactory $presetFactory,
        FilesystemInterface $imageFileSystem,
        string $wwwImageDir
    )
    {
        $this->currentAccountService = $currentAccountService;
        $this->communityRepository = $communityRepository;
        $this->themeRepository = $themeRepository;
        $this->avatarService = $avatarService;
        $this->backdropPresetFactory = $presetFactory;
        $this->backdropService = $backdropService;
        $this->imageFileSystem = $imageFileSystem;
        $this->wwwImageDir = $wwwImageDir;
    }

    public function createCommunity(CreateCommunityParameters $parameters): Community
    {
        $owner = $this->currentAccountService->getCurrentAccount();
        $entity = new Community(
            $owner,
            $parameters->getTitle(),
            $parameters->getDescription(),
            $parameters->hasThemeId()
                ? $this->themeRepository->getThemeById($parameters->getThemeId())
                : null
        );

        $this->communityRepository->createCommunity($entity);

        $strategy = new CommunityImageStrategy($entity, $this->imageFileSystem, $this->wwwImageDir);
        $this->avatarService->generateImage($strategy);
        $this->backdropService->backdropPreset($entity, $this->backdropPresetFactory, $this->backdropPresetFactory->getListIds()[array_rand($this->backdropPresetFactory->getListIds())]);
        $this->communityRepository->saveCommunity($entity);

        $this->getEventEmitter()->emit(self::EVENT_COMMUNITY_CREATED, [$entity]);

        return $entity;
    }

    public function editCommunity(int $communityId, EditCommunityParameters $parameters): Community
    {
        $community = $this->communityRepository->getCommunityById($communityId);
        $community->setTitle($parameters->getTitle());
        $community->setDescription($parameters->getDescription());

        if($parameters->hasThemeId()) {
            $community->setTheme($this->themeRepository->getThemeById($parameters->getThemeId()));
        }else{
            $community->unsetTheme();
        }

        $this->communityRepository->saveCommunity($community);
        $this->getEventEmitter()->emit(self::EVENT_COMMUNITY_UPDATED, [$community]);

        return $community;
    }

    public function uploadCommunityImage(int $communityId, UploadImageParameters $parameters): ImageCollection
    {
        $community = $this->communityRepository->getCommunityById($communityId);
        $strategy = new CommunityImageStrategy($community, $this->imageFileSystem, $this->wwwImageDir);

        $this->avatarService->uploadImage($strategy, $parameters);
        $this->communityRepository->saveCommunity($community);
        $this->getEventEmitter()->emit(self::EVENT_COMMUNITY_UPDATED, [$community]);

        return $community->getImages();
    }

    public function generateCommunityImage(int $communityId): ImageCollection
    {
        $community = $this->communityRepository->getCommunityById($communityId);
        $strategy = new CommunityImageStrategy($community, $this->imageFileSystem, $this->wwwImageDir);

        $this->avatarService->defaultImage($strategy);
        $this->communityRepository->saveCommunity($community);
        $this->getEventEmitter()->emit(self::EVENT_COMMUNITY_UPDATED, [$community]);

        return $community->getImages();
    }

    public function setPublicOptions(int $communityId, SetPublicOptionsParameters $parameters): Community
    {
        $community = $this->communityRepository->getCommunityById($communityId);

        $parameters->isPublicEnabled()
            ? $community->enablePublicDiscover()
            : $community->disablePublicDiscover();

        $parameters->isModerationContract()
            ? $community->enableModerationContract()
            : $community->disableModerationContract();

        $this->communityRepository->saveCommunity($community);
        $this->getEventEmitter()->emit(self::EVENT_COMMUNITY_UPDATED, [$community]);

        return $community;
    }

    public function deleteCommunity(int $communityId): Community
    {
        $community = $this->getCommunityById($communityId);

        $this->getEventEmitter()->emit(self::EVENT_COMMUNITY_DELETE, [$community]);
        $this->communityRepository->deleteCommunity($community);
        $this->getEventEmitter()->emit(self::EVENT_COMMUNITY_DELETED, [$community]);

        return $community;
    }

    public function updateBackdrop(Community $community)
    {
        $this->communityRepository->saveCommunity($community);
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
        $this->getEventEmitter()->emit(self::EVENT_COMMUNITY_UPDATED, [$community]);

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
        $this->getEventEmitter()->emit(self::EVENT_COMMUNITY_UPDATED, [$community]);

        return $community->getCollections();
    }

    public function getCommunitiesByIds(array $communityIds): array
    {
        $this->communityRepository->loadCommunitiesByIds($communityIds);

        return array_map(function(int $communityId) {
            return $this->getCommunityById($communityId);
        }, $communityIds);
    }

    public function loadCommunitiesByIds(array $communityIds)
    {
        $this->communityRepository->loadCommunitiesByIds($communityIds);
    }

    public function getCommunityById(string $communityId): Community
    {
        return $this->communityRepository->getCommunityById($communityId);
    }

    public function getCommunityBySID(string $communitySID): Community
    {
        return $this->communityRepository->getCommunityBySID($communitySID);
    }
}