<?php
namespace CASS\Domain\Bundles\Community\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands\ColorBackdropCommand;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Community\Service\CommunityService;
use CASS\Domain\Bundles\Colors\Repository\PaletteRepository;

final class BackdropColorCommand extends ColorBackdropCommand
{
    use BackdropCommandMixin;

    /** @var PaletteRepository */
    private $paletteRepository;

    public function __construct(
        BackdropService $backdropService,
        CommunityService $communityService,
        PaletteRepository $paletteRepository
    ) {
        $this->backdropService = $backdropService;
        $this->communityService = $communityService;
        $this->paletteRepository = $paletteRepository;
    }

    protected function getPaletteRepository(): PaletteRepository
    {
        return $this->paletteRepository;
    }
}