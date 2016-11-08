<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command\Avatar;

use CASS\Domain\Bundles\Profile\Middleware\Command\Command;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Avatar\Exception\ImageServiceException;
use CASS\Domain\Bundles\Avatar\Middleware\Request\UploadImageRequest;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface as Response;

final class ImageUploadCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): Response
    {
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