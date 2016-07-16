<?php
namespace Domain\Community\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Community\Formatter\CommunityExtendedFormatter;
use Domain\Community\Service\CommunityService;

abstract class Command implements \Application\Command\Command
{
    /** @var CurrentAccountService */
    protected $currentAccountService;

    /** @var CommunityService */
    protected $communityService;

    /** @var CommunityExtendedFormatter */
    protected $communityFormatter;

    public function __construct(
        CurrentAccountService $currentAccountService,
        CommunityService $communityService,
        CommunityExtendedFormatter $communityFormatter
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->communityService = $communityService;
        $this->communityFormatter = $communityFormatter;
    }
}