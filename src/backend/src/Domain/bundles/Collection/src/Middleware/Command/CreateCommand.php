<?php
namespace Domain\Collection\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Collection\Middleware\Request\CreateCollectionRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $collection = $this->collectionService->createCollection((new CreateCollectionRequest($request))->getParameters());

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'entity' => $collection->toJSON()
            ])
            ->build();
    }
}