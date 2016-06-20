<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Avatar\Middleware\Request\UploadImageRequest;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface as Response;

class ImageUploadCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): Response {
        try {
            $image = $this->profileService->uploadImage(
                $request->getAttribute('profileId'),
                (new UploadImageRequest($request))->getParameters()
            );

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'image' => $image->toJSON()
                ]);
        }catch (ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}