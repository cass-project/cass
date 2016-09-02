<?php
namespace CASS\Domain\Bundles\Collection\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Avatar\Exception\ImageServiceException;
use CASS\Domain\Bundles\Collection\Exception\CollectionNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ImageDeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $image = $this->collectionService->generateImage($request->getAttribute('collectionId'));

            return $responseBuilder->setStatusSuccess()->setJson([
                'image' => $image->toJSON()
            ])->build();
        }catch(ImageServiceException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusConflict();
        }catch(CollectionNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}