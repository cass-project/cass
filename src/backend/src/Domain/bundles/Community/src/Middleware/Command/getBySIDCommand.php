<?php
namespace Domain\Community\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class getBySIDCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $community = $this->communityService->getCommunityBySID($request->getAttribute('communityId'));

        return $responseBuilder->setStatusSuccess()->setJson([
            'entity' => $this->communityFormatter->format($community),
        ])->build();
    }
}