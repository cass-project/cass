<?php
namespace Domain\Collection\Middleware\Command;

use CASS\Application\REST\Response\ResponseBuilder;
use Domain\Avatar\Exception\ImageServiceException;
use Domain\Avatar\Middleware\Request\UploadImageRequest;
use Domain\Collection\Exception\CollectionNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ImageUploadCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $image = $this->collectionService->uploadImage($request->getAttribute('collectionId'), (new UploadImageRequest($request))->getParameters());

            $responseBuilder->setStatusSuccess()->setJson([
                'image' => $image->toJSON()
            ]);
        }catch(ImageServiceException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusUnprocessable();
        }catch(CollectionNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}