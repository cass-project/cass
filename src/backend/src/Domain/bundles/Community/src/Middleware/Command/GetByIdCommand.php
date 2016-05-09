<?php
namespace Domain\Community\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

final class GetByIdCommand extends Command
{
    public function run(ServerRequestInterface $request): array
    {
        $community = $this->communityService->getCommunityById($request->getAttribute('communityId'));

        return [
            'entity' => $community->toJSON()
        ];
    }
}