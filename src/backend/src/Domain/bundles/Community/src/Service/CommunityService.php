<?php
namespace Domain\Community\Service;

use Domain\Account\Entity\Account;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Collection\Repository\CollectionRepository;
use Domain\Community\ACL\CommunityACL;
use Domain\Community\Entity\Community;
use Domain\Community\Parameters\CreateCommunityParameters;
use Domain\Community\Parameters\EditCommunityParameters;
use Domain\Community\Parameters\UploadImageParameters;
use Domain\Community\Repository\CommunityRepository;
use Domain\Community\Scripts\CommunityImageUploadScript;
use Domain\Profile\Entity\Profile;
use Domain\Theme\Repository\ThemeRepository;

class CommunityService
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var CommunityRepository */
    private $communityRepository;
    
    /** @var ThemeRepository */
    private $themeRepository;
    /** @var  CollectionRepository */
    private $collectionRepository;

    /** @var string */
    private $storageDir = '';
    
    /** @var string */
    private $publicPath = '';

    public function __construct(
        CurrentAccountService $currentAccountService,
        CommunityRepository $communityRepository,
        ThemeRepository $themeRepository,
        CollectionRepository $collectionRepository,
        string $storageDir,
        string $publicPath
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->communityRepository = $communityRepository;
        $this->themeRepository = $themeRepository;
        $this->collectionRepository = $collectionRepository;
        $this->storageDir = $storageDir;
    }
    
    public function createCommunity(CreateCommunityParameters $parameters): Community {
        $owner = $this->currentAccountService->getCurrentAccount();

        $entity = new Community(
            $owner->getId(),
            $parameters->getTitle(),
            $parameters->getDescription(),
            $parameters->hasThemeId() ? $this->themeRepository->getThemeById($parameters->getThemeId()): NULL
        );

        $community = $this->communityRepository->createCommunity($entity);
        $createCollectionparameters = new CreateCollectionParameters('Лента комьюнити','');
        $collection = $this->collectionRepository->createCollection("community:{$community->getId()}", $createCollectionparameters);
        $community->getCollections()->attachChild($collection->getId());
        $this->communityRepository->saveCommunity($community);
        return $entity;
    }

    public function editCommunity(int $communityId, EditCommunityParameters $parameters): Community {
        $community = $this->communityRepository->getCommunityById($communityId);
        $community->setTitle($parameters->getTitle());
        $community->setDescription($parameters->getDescription());
        $community->setTheme($this->themeRepository->getThemeById($parameters->getThemeId()));

        $this->communityRepository->saveCommunity($community);

        return $community;
    }

    public function uploadCommunityImage(int $communityId, UploadImageParameters $parameters): Community {
        $community = $this->communityRepository->getCommunityById($communityId);
        $uploadScript = new CommunityImageUploadScript($this->storageDir);
        $params = $uploadScript->__invoke($communityId, $parameters->getTmpFile(), $parameters->getPointStart(), $parameters->getPointEnd());

        $community->setImage(new Community\CommunityImage(
            $params['path'],
            sprintf('%s/%d/%s', $this->publicPath, $params['id'], $params['file'])
        ));

        $this->communityRepository->saveCommunity($community);

        return $community;
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