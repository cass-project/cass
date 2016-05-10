<?php
namespace Domain\ProfileCommunities\Middleware\Command;

use Application\Exception\NotImplementedException;
use Psr\Http\Message\ServerRequestInterface;

class ListCommand extends Command
{
    public function __invoke(ServerRequestInterface $request) {
        return [
            'bookmarks' => $this->profileCommunitiesService->getBookmarksOfCurrentProfile()
        ];
    }
}