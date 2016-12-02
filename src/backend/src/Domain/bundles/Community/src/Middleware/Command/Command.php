<?php
namespace CASS\Domain\Bundles\Community\Middleware\Command;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Community\Formatter\CommunityExtendedFormatter;
use CASS\Domain\Bundles\Community\Formatter\CommunityFormatter;
use CASS\Domain\Bundles\Community\Service\CommunityService;

abstract class Command implements \CASS\Application\Command\Command
{
    /** @var CurrentAccountService */
    protected $currentAccountService;

    /** @var CommunityService */
    protected $communityService;

    /** @var CommunityFormatter */
    protected $communityFormatter;

    /** @var CommunityExtendedFormatter */
    protected $communityExtendedFormatter;

    public function __construct(
        CurrentAccountService $currentAccountService,
        CommunityService $communityService,
        CommunityFormatter $communityFormatter,
        CommunityExtendedFormatter $communityExtendedFormatter
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->communityService = $communityService;
        $this->communityFormatter = $communityFormatter;
        $this->communityExtendedFormatter = $communityExtendedFormatter;
    }
}