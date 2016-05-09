<?php
namespace Domain\Community\Service;

use Application\Exception\NotImplementedException;
use Domain\Community\Parameters\CreateCommunityParameters;
use Domain\Community\Parameters\EditCommunityParameters;
use Domain\Community\Parameters\UploadImageParameters;
use Domain\Community\Repository\CommunityRepository;

class CommunityService
{
    /** @var CommunityRepository */
    private $communityRepository;

    public function __construct(CommunityRepository $communityRepository)
    {
        $this->communityRepository = $communityRepository;
    }

    public function createCommunity(CreateCommunityParameters $parameters) {
        throw new NotImplementedException;
    }

    public function editCommunity(int $communityId, EditCommunityParameters $parameters) {
        throw new NotImplementedException;
    }

    public function uploadCommunityImage(int $communityId, UploadImageParameters $parameters) {
        throw new NotImplementedException;
    }
}