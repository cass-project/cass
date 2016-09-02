<?php
namespace CASS\Domain\Collection\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Collection\Exception\CollectionNotFoundException;
use CASS\Domain\Collection\Middleware\Request\EditCollectionRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EditCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $collection = $this->collectionService->editCollection(
                $request->getAttribute('collectionId'),
                (new EditCollectionRequest($request))->getParameters()
            );

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $collection->toJSON()
                ]);
        }catch(CollectionNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}