<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\ProfileCommand;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Like\Middleware\Command\Command;
use CASS\Domain\Bundles\Like\Service\LikeProfileService;
use CASS\Domain\Bundles\Profile\Service\ProfileService;
use CASS\Domain\Service\CurrentIPService\CurrentIPServiceInterface;

abstract class ProfileCommand extends Command
{
    /** @var  ProfileService */
    protected $profileService;
    /** @var LikeProfileService  */
    protected $likeProfileService;

    /** @var CurrentIPServiceInterface  */
    protected $currentIPService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        ProfileService $profileService,
        LikeProfileService $likeProfileService,
        CurrentIPServiceInterface $currentIPService
    ){
        parent::__construct( $currentAccountService);
        $this->profileService  = $profileService;
        $this->likeProfileService = $likeProfileService;
        $this->currentIPService = $currentIPService;
    }
}