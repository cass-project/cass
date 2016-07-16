<?php
namespace Domain\IM\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Profile\Service\ProfileService;
use Domain\IM\Service\ProfileIMService;

abstract class Command implements \Application\Command\Command
{
    /** @var CurrentAccountService */
    protected $currentAccountService;
    /** @var ProfileIMService */

    protected $profileIMService;

    /** @var  ProfileService */
    protected $profileService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        ProfileIMService $profileIMService,
        ProfileService $profileService
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->profileIMService = $profileIMService;
        $this->profileService = $profileService;
    }
}