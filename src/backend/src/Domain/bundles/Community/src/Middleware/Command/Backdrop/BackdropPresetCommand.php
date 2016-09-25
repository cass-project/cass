<?php
namespace CASS\Domain\Bundles\Community\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Factory\PresetFactory;
use CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands\PresetBackdropCommand;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Community\Backdrop\Preset\CommunityBackdropPresetFactory;
use CASS\Domain\Bundles\Community\Service\CommunityService;

final class BackdropPresetCommand extends PresetBackdropCommand
{
    use BackdropCommandMixin;

    /** @var CommunityBackdropPresetFactory */
    private $presetFactory;

    public function __construct(
        BackdropService $backdropService,
        CommunityService $communityService,
        CommunityBackdropPresetFactory $presetFactory
    ) {
        $this->backdropService = $backdropService;
        $this->communityService = $communityService;
        $this->presetFactory = $presetFactory;
    }

    protected function getPresetFactory(): PresetFactory
    {
        return $this->presetFactory;
    }
}