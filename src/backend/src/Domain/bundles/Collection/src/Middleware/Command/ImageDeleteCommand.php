<?php
namespace Domain\Collection\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Avatar\Exception\ImageServiceException;
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
        }

        return $responseBuilder->build();
    }
}