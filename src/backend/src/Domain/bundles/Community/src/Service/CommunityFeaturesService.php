<?php
namespace Domain\Community\Service;

use Application\Exception\NotImplementedException;
use Domain\Community\Entity\Community;
use Domain\Community\Repository\CommunityRepository;

class CommunityFeaturesService
{
    /** @var CommunityRepository */
    private $communityRepository;

    public function __construct(CommunityRepository $communityRepository) {
        $this->communityRepository = $communityRepository;
    }
    
    public function activateFeature(string $featureStringCode, Community $community) {
        throw new NotImplementedException;
    }

    public function isFeatureActivated(string $featureStringCode, Community $community): bool {
        throw new NotImplementedException;
    }

    public function deactivateFeature(string $featureStringCode, Community $community) {
        throw new NotImplementedException;
    }
}