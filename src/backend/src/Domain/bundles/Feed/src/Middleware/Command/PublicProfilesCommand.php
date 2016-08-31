<?php
namespace Domain\Feed\Middleware\Command;

use CASS\Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PublicProfilesCommand extends AbstractCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $source = $this->sourceFactory->getPublicProfilesSource();

        return $this->makeFeed($source, $request, $responseBuilder);
    }
}