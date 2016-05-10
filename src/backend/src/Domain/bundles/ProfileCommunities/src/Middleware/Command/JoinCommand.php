<?php
namespace Domain\ProfileCommunities\Middleware\Command;

use Application\Exception\NotImplementedException;
use Psr\Http\Message\ServerRequestInterface;

class JoinCommand extends Command
{
    public function __invoke(ServerRequestInterface $request) {
        $communityId = $request->getAttribute('communityId');
        
        $eq = $this->profileCommunitiesService->joinToCommunity($communityId);

        return [
            'entity' => $eq->toJSON()
        ];
    }
}