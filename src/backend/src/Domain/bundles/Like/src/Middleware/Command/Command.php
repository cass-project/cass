<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;

abstract class Command implements \CASS\Application\Command\Command
{
    /** @var CurrentAccountService  */
    protected $currentAccountService;

    public function __construct(
        CurrentAccountService $currentAccountService

    ){
        $this->currentAccountService = $currentAccountService;
    }
}