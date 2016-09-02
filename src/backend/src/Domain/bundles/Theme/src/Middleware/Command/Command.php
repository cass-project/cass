<?php
namespace CASS\Domain\Theme\Middleware\Command;

use CASS\Domain\Account\Service\AccountAppAccessService;
use CASS\Domain\Auth\Service\CurrentAccountService;
use CASS\Domain\Theme\Service\ThemeService;

abstract class Command implements \CASS\Application\Command\Command
{
    /** @var ThemeService */
    protected $themeService;

    /** @var AccountAppAccessService */
    protected $accountAppAccessService;

    /** @var CurrentAccountService */
    protected $currentAccountService;

    public function __construct(
        ThemeService $themeService,
        AccountAppAccessService $accountAppAccessService,
        CurrentAccountService $currentAccountService
    ) {
        $this->themeService = $themeService;
        $this->accountAppAccessService = $accountAppAccessService;
        $this->currentAccountService = $currentAccountService;
    }
}