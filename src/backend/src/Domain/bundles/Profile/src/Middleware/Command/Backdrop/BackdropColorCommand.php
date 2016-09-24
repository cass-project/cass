<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands\ColorBackdropCommand;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Colors\Repository\PaletteRepository;
use CASS\Domain\Bundles\Profile\Service\ProfileService;

final class BackdropColorCommand extends ColorBackdropCommand
{
    use RunMixin;

    /** @var PaletteRepository */
    private $paletterRepository;

    public function __construct(
        BackdropService $backdropService,
        ProfileService $profileService,
        PaletteRepository $paletteRepository
    ) {
        $this->backdropService = $backdropService;
        $this->profileService = $profileService;
        $this->paletterRepository = $paletteRepository;
    }

    protected function getPaletteRepository(): PaletteRepository
    {
        return $this->paletterRepository;
    }
}