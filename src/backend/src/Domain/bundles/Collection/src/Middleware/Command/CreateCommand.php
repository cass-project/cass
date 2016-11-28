<?php
namespace CASS\Domain\Bundles\Collection\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Collection\Middleware\Request\CreateCollectionRequest;
use CASS\Domain\Bundles\Community\Exception\CommunityNotFoundException;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
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
                    'entity' => $this->collectionFormatter->formatOne($collection),
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