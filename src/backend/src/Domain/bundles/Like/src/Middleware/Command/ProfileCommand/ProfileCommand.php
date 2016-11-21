<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\ProfileCommand;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Like\Middleware\Command\Command;
use CASS\Domain\Bundles\Like\Service\LikeProfileService;
use CASS\Domain\Bundles\Profile\Service\ProfileService;

abstract class ProfileCommand extends Command
{

    protected $likeProfileService;

    public function __construct(
        ProfileService $profileService,
        CurrentAccountService $currentAccountService
        , LikeProfileService $likeProfileService
    )
    {
        parent::__construct($profileService, $currentAccountService);
        $this->likeProfileService = $likeProfileService;
    }
}