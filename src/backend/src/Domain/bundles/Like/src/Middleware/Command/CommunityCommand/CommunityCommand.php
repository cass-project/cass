<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\CommunityCommand;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Community\Formatter\CommunityFormatter;
use CASS\Domain\Bundles\Community\Service\CommunityService;
use CASS\Domain\Bundles\Like\Middleware\Command\Command;
use CASS\Domain\Bundles\Like\Service\LikeCommunityService;
use CASS\Domain\Service\CurrentIPService\CurrentIPServiceInterface;

abstract class CommunityCommand extends Command
{
    protected $communityService;

    protected $likeCommunityService;

    protected $currentIPService;

    protected $communityFormatter;

    public function __construct(
        CurrentAccountService $currentAccountService,
        CommunityService $communityService,
        LikeCommunityService $likeCommunityService,
        CurrentIPServiceInterface $currentIPService,
        CommunityFormatter $communityFormatter
    )
    {
        parent::__construct($currentAccountService);

        $this->communityService = $communityService;

        $this->likeCommunityService = $likeCommunityService;

        $this->currentIPService = $currentIPService;

        $this->communityFormatter = $communityFormatter;
    }

}