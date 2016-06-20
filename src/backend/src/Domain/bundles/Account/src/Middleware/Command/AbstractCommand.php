<?php
namespace Domain\Account\Middleware\Command;

use Domain\Account\Service\AccountService;
use Domain\Auth\Service\AuthService;
use Domain\Auth\Service\CurrentAccountService;

abstract class AbstractCommand implements \Application\Command\Command
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