<?php
namespace Domain\Profile\Middleware\Command;

use CASS\Application\REST\Response\ResponseBuilder;
use Domain\Avatar\Exception\ImageServiceException;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ImageDeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $image = $this->profileService->deleteProfileImage($request->getAttribute('profileId'));

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'image' => $image->toJSON()
                ]);
        } catch (ImageServiceException $e) {
            $responseBuilder
                ->setStatusUnprocessable()
                ->setError($e);
        } catch (ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}