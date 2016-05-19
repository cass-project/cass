<?php
namespace Domain\ProfileCommunities\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class LeaveCommand extends Command
{
    public function __invoke(ServerRequestInterface $request) 
    {
        $communitySID = $request->getAttribute('communitySID');

        $this->profileCommunitiesService->leaveCommunity($communitySID);

        return [];
    }
}