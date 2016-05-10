<?php
namespace Domain\ProfileCommunities\Middleware\Command;

use Application\Exception\NotImplementedException;
use Domain\ProfileCommunities\Entity\ProfileCommunityEQ;
use Psr\Http\Message\ServerRequestInterface;

class ListCommand extends Command
{
    public function __invoke(ServerRequestInterface $request) {
        return [
            'bookmarks' => array_map(function(ProfileCommunityEQ $entity) {
                return $entity->toJSON();
            }, $this->profileCommunitiesService->getBookmarksOfCurrentProfile())
        ];
    }
}