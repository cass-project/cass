<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command\Avatar;

use CASS\Domain\Bundles\Profile\Middleware\Command\Command;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Avatar\Exception\ImageServiceException;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ImageDeleteCommand extends Command
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
                ->setStatusNotProcessable()
                ->setError($e);
        } catch (ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}