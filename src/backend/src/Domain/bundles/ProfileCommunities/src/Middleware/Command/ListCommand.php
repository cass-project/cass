<?php
namespace Domain\ProfileCommunities\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\ProfileCommunities\Entity\ProfileCommunityEQ;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $responseBuilder
            ->setJson([
                'bookmarks' => array_map(function(ProfileCommunityEQ $entity) {
                    return $entity->toJSON();
                }, $this->profileCommunitiesService->getBookmarksOfCurrentProfile())
            ])
            ->setStatusSuccess();

        return $responseBuilder->build();
    }
}