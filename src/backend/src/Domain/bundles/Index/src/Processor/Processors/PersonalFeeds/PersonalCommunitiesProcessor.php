<?php
namespace CASS\Domain\Bundles\Index\Processor\Processors\PersonalFeeds;

use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use Cocur\Chain\Chain;

final class PersonalCommunitiesProcessor extends AbstractPersonalFeedProcessor
{
    protected function getSources(Post $entity): array
    {
        $communityId = $entity->getCollection()->getOwnerId();

        return Chain::create($this->subscriptionService->listWhoSubscribedToCommunity($communityId))
            ->map(function(Subscribe $subscribe) {
                return $this->sourceFactory->getPersonalCommunitiesSource($subscribe->getProfileId());
            })
            ->array;
    }

    protected function isIndexable(Post $entity): bool
    {
        return true;
    }
}