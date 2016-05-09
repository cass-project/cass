<?php
namespace Domain\Community\Service;

use Application\Exception\NotImplementedException;
use Domain\Community\Entity\Community;
use Domain\Community\Parameters\CreateCommunityParameters;
use Domain\Community\Parameters\EditCommunityParameters;
use Domain\Community\Parameters\UploadImageParameters;
use Domain\Community\Repository\CommunityRepository;
use Domain\Community\Scripts\CommunityImageUploadScript;
use Domain\Theme\Repository\ThemeRepository;

class CommunityService
{
    /** @var CommunityRepository */
    private $communityRepository;
    
    /** @var ThemeRepository */
    private $themeRepository;

    /** @var string */
    private $storageDir = '';
    
    /** @var string */
    private $publicPath = '';

    public function __construct(CommunityRepository $communityRepository, ThemeRepository $themeRepository, string $storageDir, string $publicPath) {
        $this->communityRepository = $communityRepository;
        $this->themeRepository = $themeRepository;
        $this->storageDir = $storageDir;
    }
    
    public function createCommunity(CreateCommunityParameters $parameters): Community {
        $entity = new Community(
            $parameters->getTitle(), 
            $parameters->getDescription(), 
            $this->themeRepository->getThemeById($parameters->getThemeId())
        );
        
        $this->communityRepository->createCommunity($entity);
        
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

    public function getCommunityById(int $communityId): Community {
        return $this->communityRepository->getCommunityById($communityId);
    }
}