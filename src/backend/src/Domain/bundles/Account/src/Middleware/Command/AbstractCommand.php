<?php
namespace CASS\Domain\Account\Middleware\Command;

use CASS\Domain\Account\Service\AccountService;
use CASS\Domain\Auth\Service\AuthService;
use CASS\Domain\Auth\Service\CurrentAccountService;

abstract class AbstractCommand implements \CASS\Application\Command\Command
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