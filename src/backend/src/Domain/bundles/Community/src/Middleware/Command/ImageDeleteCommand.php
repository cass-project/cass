<?php
namespace Domain\Community\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Community\Exception\CommunityNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ImageDeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $image = $this->communityService->deleteCommunityImage($request->getAttribute('communityId'));

            return $responseBuilder->setStatusSuccess()->setJson([
                'image' => $image->toJSON()
            ])->build();
        }catch(CommunityNotFoundException $e){
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}