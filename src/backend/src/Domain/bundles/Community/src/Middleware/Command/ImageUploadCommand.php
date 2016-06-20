<?php
namespace Domain\Community\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Avatar\Exception\ImageServiceException;
use Domain\Avatar\Middleware\Request\UploadImageRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ImageUploadCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $image = $this->communityService->uploadCommunityImage($request->getAttribute('communityId'), (new UploadImageRequest($request))->getParameters());

            return $responseBuilder->setStatusSuccess()->setJson([
                'image' => $image->toJSON()
            ])->build();
        }catch(ImageServiceException $e) {
            return $responseBuilder
                ->setError($e)
                ->setStatus(422)
                ->build();
        }
    }
}