<?php
namespace CASS\Domain\Bundles\Index\Processor\Processors\PersonalFeeds;

use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use Cocur\Chain\Chain;

final class PersonalCollectionsProcessor extends AbstractPersonalFeedProcessor
{
    protected function getSources(Post $entity): array
    {
        $collectionId = $entity->getCollection()->getId();

        return Chain::create($this->subscriptionService->listWhoSubscribedToProfile($collectionId))
            ->map(function(Subscribe $subscribe) {
                return $this->sourceFactory->getPersonalCollectionsSource($subscribe->getProfileId());
            })
            ->array;
    }

    protected function isIndexable(Post $entity): bool
    {
        return true;
    }
}