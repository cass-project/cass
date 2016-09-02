<?php
namespace CASS\Domain\Feed\Factory;

use CASS\Domain\Index\Source\Sources\CollectionSource;
use CASS\Domain\Index\Source\Sources\CommunitySource;
use CASS\Domain\Index\Source\Sources\ProfileSource;
use CASS\Domain\Index\Source\Sources\PublicCatalog\PublicCollectionsSource;
use CASS\Domain\Index\Source\Sources\PublicCatalog\PublicCommunitiesSource;
use CASS\Domain\Index\Source\Sources\PublicCatalog\PublicContentSource;
use CASS\Domain\Index\Source\Sources\PublicCatalog\PublicDiscussionsSource;
use CASS\Domain\Index\Source\Sources\PublicCatalog\PublicExpertsSource;
use CASS\Domain\Index\Source\Sources\PublicCatalog\PublicProfilesSource;

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
    
    public function getCommunitySource(int $communityId): CommunitySource
    {
        return new CommunitySource($communityId);
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