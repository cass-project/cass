<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\CommunityCommand;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Community\Service\CommunityService;
use CASS\Domain\Bundles\Like\Middleware\Command\Command;
use CASS\Domain\Bundles\Like\Service\LikeCommunityService;

abstract class CommunityCommand extends Command
{
    protected $communityService;
    protected $likeCommunityService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        CommunityService $communityService,
        LikeCommunityService $likeCommunityService
    ){
        parent::__construct($currentAccountService);
        $this->communityService = $communityService;
        $this->likeCommunityService = $likeCommunityService;
    }

}