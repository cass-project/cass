<?php
namespace CASS\Domain\Bundles\Collection\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Factory\PresetFactory;
use CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands\PresetBackdropCommand;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Collection\Backdrop\Preset\CollectionBackdropPresetFactory;
use CASS\Domain\Bundles\Collection\Service\CollectionService;

final class BackdropPresetCommand extends PresetBackdropCommand
{
    use BackdropCommandMixin;

    /** @var CollectionBackdropPresetFactory */
    private $presetFactory;

    public function __construct(
        BackdropService $backdropService,
        CollectionService $collectionService,
        CollectionBackdropPresetFactory $presetFactory
    ) {
        $this->backdropService = $backdropService;
        $this->collectionService = $collectionService;
        $this->presetFactory = $presetFactory;
    }

    protected function getPresetFactory(): PresetFactory
    {
        return $this->presetFactory;
    }
}