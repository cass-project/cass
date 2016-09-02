<?php
namespace CASS\Domain\Bundles\Account\Middleware\Command;

use CASS\Application\Command\Command;
use CASS\Domain\Bundles\Account\Service\AccountService;
use CASS\Domain\Bundles\Auth\Service\AuthService;
use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;

abstract class AbstractCommand implements Command
{
    /** @var AccountService */
    protected $accountService;

    /** @var CurrentAccountService */
    protected $currentAccountService;

    /** @var AuthService */
    protected $authService;

    public function __construct(
        AccountService $accountService,
        CurrentAccountService $currentAccountService,
        AuthService $authService
    ) {
        $this->accountService = $accountService;
        $this->currentAccountService = $currentAccountService;
        $this->authService = $authService;
    }
}