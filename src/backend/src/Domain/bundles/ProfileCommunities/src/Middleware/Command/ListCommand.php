<?php
namespace CASS\Domain\Bundles\ProfileCommunities\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\ProfileCommunities\Entity\ProfileCommunityEQ;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profileId = $this->currentAccountService->getCurrentAccount()->getProfileWithId(
            $request->getAttribute('profileId')
        )->getId();

        $responseBuilder
            ->setJson([
                'bookmarks' => array_map(function(ProfileCommunityEQ $entity) {
                    return $entity->toJSON();
                }, $this->profileCommunitiesService->getBookmarksOfProfile($profileId))
            ])
            ->setStatusSuccess();

        return $responseBuilder->build();
    }
}