<?php
namespace CASS\Domain\IM\Service;

use CASS\Util\JSONSerializable;
use CASS\Domain\Community\Service\CommunityService;
use CASS\Domain\IM\Exception\Query\UnknownSourceException;
use CASS\Domain\IM\Query\Source\CommunitySource\CommunitySource;
use CASS\Domain\IM\Query\Source\ProfileSource\ProfileSource;
use CASS\Domain\IM\Query\Source\Source;
use CASS\Domain\Profile\Service\ProfileService;

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