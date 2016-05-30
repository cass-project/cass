<?php
namespace Domain\Community\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Community\Middleware\Request\EditCommunityRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EditCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $editCommunityRequest = new EditCommunityRequest($request);
        $community = $this->communityService->editCommunity($request->getAttribute('communityId'), $editCommunityRequest->getParameters());

        return $responseBuilder->setStatusSuccess()->setJson([
            'entity' => $community->toJSON()
        ])->build();
    }
}