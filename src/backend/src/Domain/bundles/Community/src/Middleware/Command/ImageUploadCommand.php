<?php
namespace Domain\Community\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Domain\Avatar\Exception\ImageServiceException;
use Domain\Avatar\Middleware\Request\UploadImageRequest;
use Domain\Community\Exception\CommunityNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ImageUploadCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $image = $this->communityService->uploadCommunityImage($request->getAttribute('communityId'), (new UploadImageRequest($request))->getParameters());

            $responseBuilder->setStatusSuccess()->setJson([
                'image' => $image->toJSON()
            ]);
        }catch(ImageServiceException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusUnprocessable();
        }catch(CommunityNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}