<?php
namespace CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop;
use CASS\Domain\Bundles\Backdrop\Factory\PresetFactory;
use Psr\Http\Message\ServerRequestInterface;

abstract class PresetBackdropCommand extends AbstractBackdropCommand
{
    protected abstract function getPresetFactory(): PresetFactory;

    protected function perform(ServerRequestInterface $request): Backdrop
    {
        // REQUIRES: parameter "presetId" in path

        $entity = $this->getBackdropAwareEntity($request);

        $service = $this->getBackdropService();
        $service->backdropPreset($entity, $this->getPresetFactory(), $request->getAttribute('presetId'));

        $this->saveBackdropAwareEntityChanges($entity);

        return $entity->getBackdrop();
    }
}