<?php
namespace CASS\Domain\Bundles\Index\Processor\Processors\PersonalFeeds;

use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use Cocur\Chain\Chain;

final class PersonalPeopleProcessor extends AbstractPersonalFeedProcessor
{
    protected function getSources(Post $entity): array
    {
        return Chain::create($this->subscriptionService->listWhoSubscribedToProfile($entity->getAuthorProfile()->getId()))
            ->map(function(Subscribe $subscribe) {
                return $this->sourceFactory->getPersonalPeopleSource($subscribe->getProfileId());
            })
            ->array;
    }

    protected function isIndexable(Post $entity): bool
    {
        return true;
    }
}