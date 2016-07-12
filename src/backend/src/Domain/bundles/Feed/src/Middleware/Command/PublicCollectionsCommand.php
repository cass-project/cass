<?php
namespace Domain\Feed\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PublicCollectionsCommand extends AbstractCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $source = $this->sourceFactory->getPublicCollectionsSource();

        return $this->makeFeed($source, $request, $responseBuilder);
    }
}