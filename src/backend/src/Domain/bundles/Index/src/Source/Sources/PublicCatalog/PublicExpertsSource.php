<?php
namespace CASS\Domain\Bundles\Index\Source\Sources\PublicCatalog;

use CASS\Domain\Bundles\Index\Source\Source;
use MongoDB\Collection;
use MongoDB\Database;

final class PublicExpertsSource implements Source
{
    public function getMongoDBCollection(): string
    {
        return 'public_experts';
    }

    public function ensureIndexes(Database $database, Collection $collection)
    {
    }
}