<?php
namespace CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands;

use CASS\Domain\Bundles\Backdrop\Entity\BackdropEntityAware;
use CASS\Domain\Bundles\Backdrop\Strategy\BackdropUploadStrategy;
use CASS\Domain\Bundles\Colors\Repository\ColorsRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Zend\Diactoros\UploadedFile;

abstract class UploadBackdropCommand extends AbstractBackdropCommand
{
    abstract protected function getBackdropUploadStrategy(ServerRequestInterface $request, BackdropEntityAware $entity): BackdropUploadStrategy;
    abstract protected function getColorRepository(): ColorsRepository;

    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
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
    }
}