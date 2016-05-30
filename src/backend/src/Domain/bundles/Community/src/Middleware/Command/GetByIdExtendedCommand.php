<?php
namespace Domain\Community\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetByIdExtendedCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $community = $this->communityService->getCommunityById($request->getAttribute('communityId'));

        return $responseBuilder->setStatusSuccess()->setJson([
            'entity' => $community->toJSON(),
            'access' => $this->communityService->getCommunityAccess($this->currentAccountService->getCurrentAccount(), $community)->toJSON()
        ])->build();
    }
}