<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Factory\PresetFactory;
use CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands\PresetBackdropCommand;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Profile\Backdrop\Preset\ProfileBackdropPresetFactory;
use CASS\Domain\Bundles\Profile\Service\ProfileService;

final class BackdropPresetCommand extends PresetBackdropCommand
{
    use RunMixin;

    /** @var ProfileBackdropPresetFactory */
    private $presetFactory;

    public function __construct(
        BackdropService $backdropService,
        ProfileService $profileService,
        ProfileBackdropPresetFactory $presetFactory
    ) {
        $this->backdropService = $backdropService;
        $this->profileService = $profileService;
        $this->presetFactory = $presetFactory;
    }

    protected function getPresetFactory(): PresetFactory
    {
        return $this->presetFactory;
    }
}