<?php
namespace CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

abstract class NoneBackdropCommand extends AbstractBackdropCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $entity = $this->getBackdropAwareEntity($request);

        $service = $this->getBackdropService();
        $service->backdropNone($entity);

        $this->saveBackdropAwareEntityChanges($entity);

        $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'backdrop' => $entity->getBackdrop()->toJSON(),
            ]);
    }
}