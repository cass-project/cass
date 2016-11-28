<?php
namespace CASS\Domain\Bundles\Index\Processor\Processors\PersonalFeeds;

use CASS\Domain\Bundles\Post\Entity\Post;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use Cocur\Chain\Chain;

final class PersonalThemesProcessor extends AbstractPersonalFeedProcessor
{
    protected function getSources(Post $entity): array
    {
        $result = [];

        foreach($entity->getThemeIds() as $themeId) {
            Chain::create($this->subscriptionService->listWhoSubscribedToTheme($themeId))
                ->map(function(Subscribe $subscribe) use (&$result) {
                    $result[$subscribe->getProfileId()] = true;
                })
                ->array;
        }

        return Chain::create(array_keys($result))
            ->map(function(int $profileId) {
                return $this->sourceFactory->getPersonalThemesSource($profileId);
            })
            ->array;
    }

    protected function isIndexable(Post $entity): bool
    {
        return true;
    }
}