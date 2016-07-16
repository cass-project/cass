<?php
namespace Domain\IM\Service;

use Application\Util\JSONSerializable;
use Domain\Community\Service\CommunityService;
use Domain\IM\Exception\Query\UnknownSourceException;
use Domain\IM\Query\Source\CommunitySource\CommunitySource;
use Domain\IM\Query\Source\ProfileSource\ProfileSource;
use Domain\IM\Query\Source\Source;
use Domain\Profile\Service\ProfileService;

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
            return $this->profileService->getProfileById($source->getSourceId());
        }else if($source instanceof CommunitySource) {
            return $this->communityService->getCommunityById($source->getSourceId());
        }else{
            throw new UnknownSourceException(sprintf('Unknown source `%s`', get_class($source)));
        }
    }
}