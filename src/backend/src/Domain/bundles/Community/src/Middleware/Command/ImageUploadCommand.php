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
            $community = $this->communityService->uploadCommunityImage($request->getAttribute('communityId'), (new UploadImageRequest($request))->getParameters());

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