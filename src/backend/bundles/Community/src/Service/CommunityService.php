<?php
namespace Community\Service;

use Auth\Service\CurrentAccountService;
use Common\Exception\NotImplementedException;
use Community\Parameters\CreateCommunityParameters;
use Community\Parameters\EditCommunityParameters;
use Community\Parameters\UploadImageParameters;
use Community\Repository\CommunityRepository;

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