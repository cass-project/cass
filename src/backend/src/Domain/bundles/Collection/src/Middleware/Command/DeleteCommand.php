<?php
namespace Domain\Collection\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Domain\Collection\Exception\CollectionIsProtectedException;
use Domain\Collection\Exception\CollectionNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $collectionId = $request->getAttribute('collectionId');

        try {
            $this->collectionService->deleteCollection($collectionId);

            $responseBuilder->setStatusSuccess();
        }catch(CollectionIsProtectedException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusConflict();
        }catch(CollectionNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}