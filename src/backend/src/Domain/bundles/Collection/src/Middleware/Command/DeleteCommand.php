<?php
namespace Domain\Collection\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $collectionId = $request->getAttribute('collectionId');

        $this->collectionService->deleteCollection($collectionId);

        return $responseBuilder
            ->setStatusSuccess()
            ->build();
    }
}