<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Avatar\Exception\ImageServiceException;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
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