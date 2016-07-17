<?php
namespace Domain\Feed\Factory;

use Domain\Index\Source\Sources\CollectionSource;
use Domain\Index\Source\Sources\ProfileSource;
use Domain\Index\Source\Sources\PublicCatalog\PublicCollectionsSource;
use Domain\Index\Source\Sources\PublicCatalog\PublicCommunitiesSource;
use Domain\Index\Source\Sources\PublicCatalog\PublicContentSource;
use Domain\Index\Source\Sources\PublicCatalog\PublicDiscussionsSource;
use Domain\Index\Source\Sources\PublicCatalog\PublicExpertsSource;
use Domain\Index\Source\Sources\PublicCatalog\PublicProfilesSource;

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

    public function getPublicCollectionsSource(): PublicCollectionsSource
    {
        return new PublicCollectionsSource();
    }
    
    public function getPublicCommunitiesSource(): PublicCommunitiesSource
    {
        return new PublicCommunitiesSource();
    }
    
    public function getPublicContentSource(): PublicContentSource
    {
        return new PublicContentSource();
    }
    
    public function getPublicDiscussionsSource(): PublicDiscussionsSource
    {
        return new PublicDiscussionsSource();
    }
    
    public function getPublicExpertsSource(): PublicExpertsSource
    {
        return new PublicExpertsSource();
    }
    
    public function getPublicProfilesSource(): PublicProfilesSource
    {
        return new PublicProfilesSource();
    }
}