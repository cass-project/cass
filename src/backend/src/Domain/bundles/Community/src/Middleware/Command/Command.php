<?php
namespace Domain\Community\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Community\Service\CommunityService;

abstract class Command implements \Application\Command\Command
{
    /** @var CurrentAccountService */
    protected $currentAccountService;

    /** @var CommunityService */
    protected $communityService;

    public function __construct(CurrentAccountService $currentAccountService, CommunityService $communityService)
    {
        $this->currentAccountService = $currentAccountService;
        $this->communityService = $communityService;
    }
}