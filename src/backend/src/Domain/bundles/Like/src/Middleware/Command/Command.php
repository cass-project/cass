<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command;

use CASS\Domain\Bundles\Profile\Service\ProfileService;

abstract class Command implements \CASS\Application\Command\Command
{

    /** @var  ProfileService */
    protected $profileService;

    public function __construct(
        ProfileService $profileService
    ){

    }
}