<?php
namespace Domain\Collection\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Domain\Collection\Middleware\Request\CreateCollectionRequest;
use Domain\Community\Exception\CommunityNotFoundException;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $collection = $this->collectionService->createCollection((new CreateCollectionRequest($request))->getParameters());

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $collection->toJSON()
                ]);
        }catch(CommunityNotFoundException $e){
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}