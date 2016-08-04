<?php
namespace Domain\Collection\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Collection\Exception\CollectionNotFoundException;
use Domain\Collection\Middleware\Request\EditCollectionRequest;
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