<?php
namespace Domain\ProfileCommunities\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class JoinCommand extends Command
{
    public function __invoke(ServerRequestInterface $request) {
        $communitySID = $request->getAttribute('communitySID');

        $eq = $this->profileCommunitiesService->joinToCommunity($communitySID);

        return [
            'entity' => $eq->toJSON()
        ];
    }
}