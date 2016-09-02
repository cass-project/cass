<?php
namespace CASS\Domain\Community\Middleware\Command\Feature;

use CASS\Application\Command\Command;
use CASS\Domain\Community\Service\CommunityFeaturesService;
use CASS\Domain\Community\Service\CommunityService;

abstract class AbstractFeatureCommand implements Command
{
    /** @var CommunityService */
    protected $communityService;

    /** @var CommunityFeaturesService */
    protected $communityFeatureService;

    public function __construct(
        CommunityService $communityService,
        CommunityFeaturesService $communityFeatureService
    ) {
        $this->communityService = $communityService;
        $this->communityFeatureService = $communityFeatureService;
    }
}