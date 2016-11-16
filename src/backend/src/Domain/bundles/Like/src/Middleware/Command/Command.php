<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Profile\Service\ProfileService;

abstract class Command implements \CASS\Application\Command\Command
{

    /** @var  ProfileService */
    protected $profileService;

    /** @var CurrentAccountService  */
    protected $currentAccountService;

    public function __construct(
        ProfileService $profileService,
        CurrentAccountService $currentAccountService

    ){
        $this->profileService = $profileService;
        $this->currentAccountService = $currentAccountService;
    }
}