<?php
namespace CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands;

use CASS\Application\Command\Command;
use CASS\Domain\Bundles\Backdrop\Entity\Backdrop;
use CASS\Domain\Bundles\Backdrop\Entity\BackdropEntityAware;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractBackdropCommand implements Command
{
    abstract protected function perform(ServerRequestInterface $request): Backdrop;
    abstract protected function getBackdropAwareEntity(ServerRequestInterface $request): BackdropEntityAware;
    abstract protected function getBackdropService(): BackdropService;
    abstract protected function saveBackdropAwareEntityChanges(BackdropEntityAware $entity);
}