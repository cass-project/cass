<?php
namespace Domain\Feed\Source\PublicCatalog;

use Domain\Feed\Service\Entity;
use Domain\Feed\Source\Source;
use Domain\Profile\Entity\Profile;

final class PublicProfilesSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_profiles';
    }

    public function test(Entity $entity)
    {
        return $entity instanceof Profile;
    }
}