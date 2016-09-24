<?php
namespace CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands;

use CASS\Domain\Bundles\Backdrop\Factory\PresetFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

abstract class PresetBackdropCommand extends AbstractBackdropCommand
{
    protected abstract function getPresetFactory(): PresetFactory;

    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        // REQUIRES: parameter "presetId" in path

        $entity = $this->getBackdropAwareEntity($request);

        $service = $this->getBackdropService();
        $service->backdropPreset($entity, $this->getPresetFactory(), $request->getAttribute('presetId'));

        $this->saveBackdropAwareEntityChanges($entity);

        $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'backdrop' => $entity->getBackdrop()->toJSON(),
            ]);
    }
}