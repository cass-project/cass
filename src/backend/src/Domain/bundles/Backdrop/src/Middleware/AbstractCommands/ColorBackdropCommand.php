<?php
namespace CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop;
use CASS\Domain\Bundles\Colors\Repository\PaletteRepository;
use Psr\Http\Message\ServerRequestInterface;

abstract class ColorBackdropCommand extends AbstractBackdropCommand
{
    abstract protected function getPaletteRepository(): PaletteRepository;

    protected function perform(ServerRequestInterface $request): Backdrop
    {
        // REQUIRES: parameter "code" (palette) in path

        $entity = $this->getBackdropAwareEntity($request);

        $service = $this->getBackdropService();
        $service->backdropColor($entity, $this->getPaletteRepository()->getPalette($request->getAttribute('code')));

        $this->saveBackdropAwareEntityChanges($entity);

        return $entity->getBackdrop();
    }
}