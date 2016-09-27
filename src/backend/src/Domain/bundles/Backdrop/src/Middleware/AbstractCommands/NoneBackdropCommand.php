<?php
namespace CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop;
use Psr\Http\Message\ServerRequestInterface;

abstract class NoneBackdropCommand extends AbstractBackdropCommand
{
    protected function perform(ServerRequestInterface $request): Backdrop
    {
        $entity = $this->getBackdropAwareEntity($request);

        $service = $this->getBackdropService();
        $service->backdropNone($entity);

        $this->saveBackdropAwareEntityChanges($entity);

        return $entity->getBackdrop();
    }
}