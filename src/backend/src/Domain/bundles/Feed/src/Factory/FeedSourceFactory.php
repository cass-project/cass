<?php
namespace Domain\Feed\Factory;

use Domain\Feed\Source\CollectionSource;
use Domain\Feed\Source\ProfileSource;

final class FeedSourceFactory
{
    public function getProfileSource(int $profileId): ProfileSource
    {
        return new ProfileSource($profileId);
    }

    public function getCollectionSource(int $collectionId): CollectionSource
    {
        return new CollectionSource($collectionId);
    }
}