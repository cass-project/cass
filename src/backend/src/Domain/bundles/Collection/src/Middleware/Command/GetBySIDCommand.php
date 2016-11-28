<?php
namespace CASS\Domain\Bundles\Collection\Middleware\Command;

use CASS\Domain\Bundles\Collection\Exception\CollectionNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

final class GetBySIDCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $collection = $this->collectionService->getCollectionBySID($request->getAttribute('collectionSID'));

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $this->collectionFormatter->formatOne($collection),
                ]);
        }catch(CollectionNotFoundException $e){
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}