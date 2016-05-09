<?php
namespace Domain\Community\Middleware\Command;

use Domain\Community\Middleware\Request\EditCommunityRequest;
use Psr\Http\Message\ServerRequestInterface;

final class EditCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $editCommunityRequest = new EditCommunityRequest($request);
        $community = $this->communityService->editCommunity($request->getAttribute('communityId'), $editCommunityRequest->getParameters());

        return [
            'entity' => $community->toJSON()
        ];
    }
}