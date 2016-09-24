<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands\NoneBackdropCommand;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Profile\Service\ProfileService;

final class BackdropNoneCommand extends NoneBackdropCommand
{
    use RunMixin;

    public function __construct(
        BackdropService $backdropService,
        ProfileService $profileService
    ) {
        $this->backdropService = $backdropService;
        $this->profileService = $profileService;
    }
}