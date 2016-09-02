<?php
namespace CASS\Domain\Community\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Avatar\Exception\ImageServiceException;
use CASS\Domain\Community\Exception\CommunityNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ImageDeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $image = $this->communityService->generateCommunityImage($request->getAttribute('communityId'));

            $responseBuilder->setStatusSuccess()->setJson([
                'image' => $image->toJSON()
            ]);
        }catch(CommunityNotFoundException $e){
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }catch(ImageServiceException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusUnprocessable();
        }

        return $responseBuilder->build();
    }
}