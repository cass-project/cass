<?php
namespace CASS\Domain\Bundles\Community\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands\NoneBackdropCommand;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Community\Service\CommunityService;

final class BackdropNoneCommand extends NoneBackdropCommand
{
    use BackdropCommandMixin;

    public function __construct(
        BackdropService $backdropService,
        CommunityService $communityService
    ) {
        $this->backdropService = $backdropService;
        $this->communityService = $communityService;
    }

}