<?php
namespace CASS\Domain\Bundles\Feed\Middleware\Command\PublicCatalog;

use CASS\Domain\Bundles\Feed\Middleware\Command\AbstractCommand;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PublicCommunitiesCommand extends AbstractCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $source = $this->sourceFactory->getPublicCommunitiesSource();

        return $this->makeFeed($source, $request, $responseBuilder);
    }
}