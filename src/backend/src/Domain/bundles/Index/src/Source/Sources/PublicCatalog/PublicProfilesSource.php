<?php
namespace CASS\Domain\Bundles\Index\Source\Sources\PublicCatalog;

use CASS\Domain\Bundles\Index\Source\Source;
use MongoDB\Collection;
use MongoDB\Database;

final class PublicProfilesSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_profiles';
    }

    public function ensureIndexes(Database $database, Collection $collection)
    {
    }
}