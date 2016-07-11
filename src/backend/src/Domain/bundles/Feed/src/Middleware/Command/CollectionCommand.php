<?php
namespace Domain\Feed\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CollectionCommand extends AbstractCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $collectionId = (int) $request->getAttribute('collectionId');
        $source = $this->sourceFactory->getCollectionSource($collectionId);

        return $this->makeFeed($source, $request, $responseBuilder);
    }
}