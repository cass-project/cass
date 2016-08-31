<?php
namespace Domain\Community\Middleware\Command\Feature;

use CASS\Application\Command\Command;
use Domain\Community\Service\CommunityFeaturesService;
use Domain\Community\Service\CommunityService;

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