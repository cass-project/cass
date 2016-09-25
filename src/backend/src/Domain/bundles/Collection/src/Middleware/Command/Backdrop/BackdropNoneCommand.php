<?php
namespace CASS\Domain\Bundles\Collection\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands\NoneBackdropCommand;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Collection\Service\CollectionService;

final class BackdropNoneCommand extends NoneBackdropCommand
{
    use BackdropCommandMixin;

    public function __construct(
        BackdropService $backdropService,
        CollectionService $collectionService
    ) {
        $this->backdropService = $backdropService;
        $this->collectionService = $collectionService;
    }

}