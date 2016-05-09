<?php
namespace Domain\Community\Middleware\Command;

use Domain\Community\Middleware\Request\CreateCommunityRequest;
use Psr\Http\Message\ServerRequestInterface;

final class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request): array
    {
        $createCommunityRequest = new CreateCommunityRequest($request);
        $community = $this->communityService->createCommunity($createCommunityRequest->getParameters());

        return [
            'entity' => $community->toJSON()
        ];
    }
}