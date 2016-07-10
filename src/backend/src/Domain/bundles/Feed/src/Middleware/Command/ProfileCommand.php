<?php
namespace Domain\Feed\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ProfileCommand extends AbstractCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profileId = (int) $request->getAttribute('profileId');
        $source = $this->sourceFactory->getProfileSource($profileId);

        return $this->makeFeed($source, $request, $responseBuilder);
    }
}