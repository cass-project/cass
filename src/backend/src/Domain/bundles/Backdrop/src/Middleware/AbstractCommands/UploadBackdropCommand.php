<?php
namespace CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop;
use CASS\Domain\Bundles\Backdrop\Entity\BackdropEntityAware;
use CASS\Domain\Bundles\Backdrop\Strategy\BackdropUploadStrategy;
use CASS\Domain\Bundles\Colors\Repository\ColorsRepository;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\UploadedFile;

abstract class UploadBackdropCommand extends AbstractBackdropCommand
{
    abstract protected function getBackdropUploadStrategy(ServerRequestInterface $request, BackdropEntityAware $entity): BackdropUploadStrategy;

    protected function perform(ServerRequestInterface $request): Backdrop
    {
        // REQUIRES: POST request
        // REQUIRES: file in POST
        // REQUIRES: parameter 'textColor' in path

        $entity = $this->getBackdropAwareEntity($request);

        /** @var UploadedFile $file */
        $file = $request->getUploadedFiles()['file'];
        $tmpF = $file->getStream()->getMetadata('uri');

        $service = $this->getBackdropService();
        $service->backdropUpload(
            $entity,
            $this->getBackdropUploadStrategy($request, $entity),
            $request->getAttribute('textColor'),
            $tmpF
        );

        return $entity->getBackdrop();
    }
}