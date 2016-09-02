<?php
namespace CASS\Domain\Feed\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CommunityCommand extends AbstractCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $communityId = (int) $request->getAttribute('communityId');
        $source = $this->sourceFactory->getCommunitySource($communityId);

        return $this->makeFeed($source, $request, $responseBuilder);
    }
}