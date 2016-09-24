<?php
namespace CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands;

use CASS\Domain\Bundles\Colors\Repository\PaletteRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

abstract class ColorBackdropCommand extends AbstractBackdropCommand
{
    abstract protected function getPaletteRepository(): PaletteRepository;

    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        // REQUIRES: parameter "code" (palette) in path

        $entity = $this->getBackdropAwareEntity($request);

        $service = $this->getBackdropService();
        $service->backdropColor($entity, $this->getPaletteRepository()->getPalette($request->getAttribute('code')));

        $this->saveBackdropAwareEntityChanges($entity);

        $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'backdrop' => $entity->getBackdrop()->toJSON(),
            ]);
    }
}