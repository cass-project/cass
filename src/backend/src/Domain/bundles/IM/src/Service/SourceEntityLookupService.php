<?php
namespace CASS\Domain\Bundles\IM\Service;

use CASS\Util\JSONSerializable;
use CASS\Domain\Bundles\Community\Service\CommunityService;
use CASS\Domain\Bundles\IM\Exception\Query\UnknownSourceException;
use CASS\Domain\Bundles\IM\Query\Source\CommunitySource\CommunitySource;
use CASS\Domain\Bundles\IM\Query\Source\ProfileSource\ProfileSource;
use CASS\Domain\Bundles\IM\Query\Source\Source;
use CASS\Domain\Bundles\Profile\Service\ProfileService;

final class SourceEntityLookupService
{
    /** @var ProfileService */
    private $profileService;

    /** @var CommunityService */
    private $communityService;

    public function __construct(ProfileService $profileService, CommunityService $communityService)
    {
        $this->profileService = $profileService;
        $this->communityService = $communityService;
    }

    public function getEntityForSource(Source $source): JSONSerializable
    {
        if($source instanceof ProfileSource) {
            return $this->profileService->getProfileById($source->getTargetProfileId());
        }else if($source instanceof CommunitySource) {
            return $this->communityService->getCommunityById($source->getSourceId());
        }else{
            throw new UnknownSourceException(sprintf('Unknown source `%s`', get_class($source)));
        }
    }
}