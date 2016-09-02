<?php
namespace CASS\Domain\Community\Service;

use CASS\Application\Exception\NotImplementedException;
use CASS\Domain\Community\Entity\Community;
use CASS\Domain\Community\Exception\FeatureIsActivatedException;
use CASS\Domain\Community\Exception\FeatureIsNotActivatedException;
use CASS\Domain\Community\Feature\FeaturesFactory;
use CASS\Domain\Community\Repository\CommunityRepository;

class CommunityFeaturesService
{
    /** @var CommunityRepository */
    private $communityRepository;

    /** @var FeaturesFactory */
    private $featureFactory;

    public function __construct(CommunityRepository $communityRepository, FeaturesFactory $featureFactory)
    {
        $this->communityRepository = $communityRepository;
        $this->featureFactory = $featureFactory;
    }

    public function activateFeature(string $featureStringCode, Community $community) {
        $feature = $this->featureFactory->createFeatureFromStringCode($featureStringCode);

        if($feature->isActivated($community)) {
            throw new FeatureIsActivatedException(sprintf('Feature `%s` is already activated for community `%d`', $featureStringCode, $community->getId()));
        }

        $feature->activate($community);

        $this->communityRepository->activateFeature($community, $featureStringCode);
    }

    public function isFeatureActivated(string $featureStringCode, Community $community): bool {
        $feature = $this->featureFactory->createFeatureFromStringCode($featureStringCode);

        return $feature->isActivated($community);
    }

    public function deactivateFeature(string $featureStringCode, Community $community) {
        $feature = $this->featureFactory->createFeatureFromStringCode($featureStringCode);

        if(! $feature->isActivated($community)) {
            throw new FeatureIsNotActivatedException(sprintf('Feature `%s` is not activated for community `%d`', $featureStringCode, $community->getId()));
        }

        $feature->deactivate($community);

        $this->communityRepository->deactivateFeature($community, $featureStringCode);
    }
}