<?php
namespace Domain\Feed\Factory;

use Domain\Feed\Source\CollectionSource;
use Domain\Feed\Source\ProfileSource;
use Domain\Feed\Source\PublicCatalog\PublicCollectionsSource;
use Domain\Feed\Source\PublicCatalog\PublicCommunitiesSource;
use Domain\Feed\Source\PublicCatalog\PublicContentSource;
use Domain\Feed\Source\PublicCatalog\PublicDiscussionsSource;
use Domain\Feed\Source\PublicCatalog\PublicExpertsSource;
use Domain\Feed\Source\PublicCatalog\PublicProfilesSource;

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