<?php
namespace CASS\Domain\Bundles\Collection\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands\ColorBackdropCommand;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Collection\Service\CollectionService;
use CASS\Domain\Bundles\Colors\Repository\PaletteRepository;

final class BackdropColorCommand extends ColorBackdropCommand
{
    use BackdropCommandMixin;

    /** @var PaletteRepository */
    private $paletteRepository;

    public function __construct(
        BackdropService $backdropService,
        CollectionService $collectionService,
        PaletteRepository $paletteRepository
    ) {
        $this->backdropService = $backdropService;
        $this->collectionService = $collectionService;
        $this->paletteRepository = $paletteRepository;
    }

    protected function getPaletteRepository(): PaletteRepository
    {
        return $this->paletteRepository;
    }
}