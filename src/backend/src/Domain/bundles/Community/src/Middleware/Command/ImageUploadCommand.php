<?php
namespace Domain\Community\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Application\Util\Scripts\AvatarUploadScriptException;
use Domain\Community\Middleware\Request\UploadImageRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ImageUploadCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $uploadImageRequest = new UploadImageRequest($request);
            $community = $this->communityService->uploadCommunityImage($request->getAttribute('communityId'), $uploadImageRequest->getParameters());

            return $responseBuilder->setStatusSuccess()->setJson([
                'image' => $community->getImage()->toJSON()
            ])->build();
        }catch(AvatarUploadScriptException $e) {
            return $responseBuilder
                ->setError($e)
                ->setStatus(422)
                ->build();
        }
    }
}